<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book an Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('booking.store') }}" id="bookingForm">
                        @csrf
                        
                        <!-- Hairdresser Selection -->
                        <div class="mb-4">
                            <label for="hairdresser_id" class="block text-sm font-medium text-gray-700">Choose Hairdresser</label>
                            <select id="hairdresser_id" name="hairdresser_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Select a professional...</option>
                                @foreach($hairdressers as $h)
                                    <option value="{{ $h->id }}">{{ $h->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date Selection -->
                        <div class="mb-4">
                            <label for="appointment_date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" id="appointment_date" name="appointment_date" min="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <!-- Time Selection (Populated via JS) -->
                        <div class="mb-4">
                            <label for="start_time" class="block text-sm font-medium text-gray-700">Available Times</label>
                            <select id="start_time" name="start_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" disabled>
                                <option value="">Select a date and hairdresser first.</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Book Appointment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const hairdresserSelect = document.getElementById('hairdresser_id');
        const dateInput = document.getElementById('appointment_date');
        const timeSelect = document.getElementById('start_time');

        function fetchSlots() {
            const hId = hairdresserSelect.value;
            const date = dateInput.value;

            if (hId && date) {
                timeSelect.innerHTML = '<option value="">Loading...</option>';
                timeSelect.disabled = true;

                fetch(`{{ route('booking.slots') }}?hairdresser_id=${hId}&date=${date}`)
                    .then(response => response.json())
                    .then(data => {
                        timeSelect.innerHTML = '<option value="">Select a time</option>';
                        if(data.slots && data.slots.length > 0) {
                            data.slots.forEach(slot => {
                                timeSelect.innerHTML += `<option value="${slot}">${slot}</option>`;
                            });
                            timeSelect.disabled = false;
                        } else {
                            timeSelect.innerHTML = `<option value="">${data.message || 'No slots available'}</option>`;
                        }
                    });
            } else {
                timeSelect.innerHTML = '<option value="">Select a date and hairdresser first.</option>';
                timeSelect.disabled = true;
            }
        }

        hairdresserSelect.addEventListener('change', fetchSlots);
        dateInput.addEventListener('change', fetchSlots);
    </script>
</x-app-layout>
