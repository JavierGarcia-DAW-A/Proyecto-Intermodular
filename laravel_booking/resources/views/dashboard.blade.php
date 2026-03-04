<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            @if(!auth()->user()->is_admin)
                <a href="{{ route('booking.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Book New Appointment
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">
                        {{ auth()->user()->is_admin ? 'All Appointments (Admin)' : 'Your Appointments' }}
                    </h3>

                    @if($appointments->isEmpty())
                        <p class="text-gray-500">No appointments found.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        @if(auth()->user()->is_admin)
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client Name</th>
                                        @endif
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hairdresser</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                        @if(auth()->user()->is_admin)
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($appointments as $appointment)
                                        <tr>
                                            @if(auth()->user()->is_admin)
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $appointment->user->name ?? 'N/A' }}</td>
                                            @endif
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $appointment->hairdresser->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</td>
                                            
                                            @if(auth()->user()->is_admin)
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <form method="POST" action="{{ route('appointments.destroy', $appointment) }}" onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Delete</button>
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
