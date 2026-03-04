<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hairdresser;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $hairdressers = Hairdresser::all();
        return view('booking.index', compact('hairdressers'));
    }

    public function fetchSlots(Request $request)
    {
        $date = Carbon::parse($request->date);
        
        // Block Sundays
        if ($date->isSunday()) {
            return response()->json(['slots' => [], 'message' => 'Sundays are not available.']);
        }

        $hairdresserId = $request->hairdresser_id;
        $slots = [];

        // Define available hours
        // Mon-Fri: 9-14 and 16-21
        // Sat: 9-14 only
        
        $morningStart = 9;
        $morningEnd = 14;
        $afternoonStart = 16;
        $afternoonEnd = 21;

        $periods = [
            ['start' => $morningStart, 'end' => $morningEnd],
        ];

        if (!$date->isSaturday()) {
            $periods[] = ['start' => $afternoonStart, 'end' => $afternoonEnd];
        }

        // Generate 30min slots
        foreach ($periods as $period) {
            $current = Carbon::parse($date->format('Y-m-d') . ' ' . str_pad($period['start'], 2, '0', STR_PAD_LEFT) . ':00:00');
            $end = Carbon::parse($date->format('Y-m-d') . ' ' . str_pad($period['end'], 2, '0', STR_PAD_LEFT) . ':00:00');
            
            while ($current < $end) {
                $slots[] = $current->format('H:i');
                $current->addMinutes(30);
            }
        }

        // Get booked slots to filter out
        $bookedAppointments = Appointment::where('appointment_date', $date->format('Y-m-d'))
            ->where('hairdresser_id', $hairdresserId)
            ->pluck('start_time')
            ->map(function ($time) {
                return Carbon::parse($time)->format('H:i');
            })->toArray();

        $availableSlots = array_values(array_filter($slots, function($slot) use ($bookedAppointments) {
            return !in_array($slot, $bookedAppointments);
        }));

        return response()->json(['slots' => $availableSlots]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'hairdresser_id' => 'required|exists:hairdressers,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
        ]);

        $date = Carbon::parse($request->appointment_date);
        
        // Final structural validation just in case
        if ($date->isSunday() || ($date->isSaturday() && Carbon::parse($request->start_time)->hour >= 14)) {
            return back()->withErrors('Invalid time selection based on operating hours.');
        }

        $startTime = Carbon::parse($request->start_time);
        $endTime = $startTime->copy()->addMinutes(30);

        // Check if slot still available
        $exists = Appointment::where('appointment_date', $date->format('Y-m-d'))
            ->where('hairdresser_id', $request->hairdresser_id)
            ->where('start_time', $startTime->format('H:i:s'))
            ->exists();

        if ($exists) {
            return back()->withErrors('This time slot has already been booked.');
        }

        Appointment::create([
            'user_id' => Auth::id(),
            'hairdresser_id' => $request->hairdresser_id,
            'appointment_date' => $date->format('Y-m-d'),
            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),
        ]);

        return redirect()->route('dashboard')->with('success', 'Appointment booked successfully!');
    }
}
