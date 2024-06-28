@php
    use App\Models\Car;
    $cars = Car::all();
    $duration = 0;
    $total_price = 0;
    $is_completed = 0;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Booking Car') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto bg-white shadow dark:bg-gray-800 sm:rounded-lg">
            <div class="p-6">
                <form method="post" action="{{ route('rental.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <!-- Car Selection -->
                            <div>
                                <label for="car_id"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                                    Mobil:</label>
                                <div class="relative mt-1">
                                    <x-select id="car_id" name="car_id"
                                        class="block w-full py-2 pl-3 pr-10 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-gray-600 dark:focus:border-gray-600 sm:text-sm">
                                        <option value="">Pilih Mobil</option>
                                        @foreach ($cars as $car)
                                            <option value="{{ $car->id }}"
                                                {{ old('car_id') == $car->id ? 'selected' : '' }}>
                                                {{ $car->name }}
                                            </option>
                                        @endforeach
                                    </x-select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Car Details -->
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Brand:</span>
                                    <span id="brand"
                                        class="block text-sm font-medium text-gray-900 dark:text-white"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type:</span>
                                    <span id="type"
                                        class="block text-sm font-medium text-gray-900 dark:text-white"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga/Hari:</span>
                                    <span id="price"
                                        class="block text-sm font-medium text-gray-900 dark:text-white"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">License:</span>
                                    <span id="license"
                                        class="block text-sm font-medium text-gray-900 dark:text-white"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <!-- Car Image -->
                            <div class="flex justify-center">
                                <img id="car_image" src="{{ asset('placeholder_image.jpg') }}" alt="Car Image"
                                    class="w-full max-h-[400px] rounded-lg">
                            </div>

                            <!-- Date Selection -->
                            <div>
                                <label for="start_date"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start
                                    day:</label>
                                <div class="relative mt-1">
                                    <input type="text" id="start_date" name="start_date"
                                        class="block w-full py-2 pr-10 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-gray-600 dark:focus:border-gray-600 sm:text-sm"
                                        placeholder="Pilih tanggal mulai" readonly>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="end_date"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">End day:</label>
                                <div class="relative mt-1">
                                    <input type="text" id="end_date" name="end_date"
                                        class="block w-full py-2 pr-10 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-gray-600 dark:focus:border-gray-600 sm:text-sm"
                                        placeholder="Pilih tanggal selesai" readonly>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Duration and Total Price -->
                            <div>
                                <label for="duration"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Duration
                                    (Hari):</label>
                                <input id="duration" name="duration" type="text"
                                    class="block w-full py-2 pr-10 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-gray-600 dark:focus:border-gray-600 sm:text-sm"
                                    readonly>
                            </div>
                            <div>
                                <label for="total_price"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total
                                    Price:</label>
                                <input id="total_price" name="total_price" type="text"
                                    class="block w-full py-2 pr-10 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-gray-600 dark:focus:border-gray-600 sm:text-sm"
                                    readonly>
                            </div>

                            <!-- Informasi Transfer Pembayaran -->
                            <div class="mt-6">
                                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300">Informasi Transfer
                                    Pembayaran:</h3>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                    Silakan transfer pembayaran ke rekening berikut:
                                </p>
                                <ul class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    <li><strong>Bank:</strong> BNI</li>
                                    <li><strong>Nomor Rekening:</strong> 1329890</li>
                                    <li><strong>Nama Penerima:</strong> Wilbert Tegar</li>
                                </ul>
                            </div>

                            <!-- Bukti Pembayaran -->
                            <div>
                                <label for="proof_payment"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bukti
                                    Pembayaran:</label>
                                <input type="file" id="proof_payment" name="proof_payment"
                                    class="block w-full py-2 pr-10 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-gray-600 dark:focus:border-gray-600 sm:text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25">
                            <span class="mr-1">Rent Car</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v6a1 1 0 11-2 0V3a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                                <path fill-rule="evenodd" d="M10 18a1 1 0 01-1-1v-6a1 1 0 112 0v6a1 1 0 01-1 1z"
                                    clip-rule="evenodd"></path>
                                <path fill-rule="evenodd" d="M4 10a1 1 0 011-1h6a1 1 0 110 2H5a1 1 0 01-1-1z"
                                    clip-rule="evenodd"></path>
                                <path fill-rule="evenodd" d="M14 9a1 1 0 00-1-1H7a1 1 0 100 2h6a1 1 0 001-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
    <script>
        $(function() {
            // Your existing script for datepicker and car details
            // ...
        });
    </script>
@endsection





<style>
    /* Style untuk datepicker */
    .ui-datepicker {
        background-color: #ffffff;
        border: 1px solid #ddd;
        color: #333333;
        padding: 10px;
        font-family: Arial, sans-serif;
    }

    .ui-datepicker-header {
        background-color: #4a90e2;
        border-bottom: 1px solid #ddd;
        color: #ffffff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 10px;
    }

    .ui-datepicker-title {
        font-weight: bold;
    }

    .ui-datepicker-prev,
    .ui-datepicker-next {
        background-color: #4a90e2;
        border: 1px solid #3672c4;
        color: #ffffff;
        padding: 6px 10px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .ui-datepicker-prev:hover,
    .ui-datepicker-next:hover {
        background-color: #3672c4;
    }

    .ui-datepicker-calendar {
        background-color: #ffffff;
        border: none;
        color: #333333;
    }

    .ui-datepicker-calendar .ui-state-default {
        background-color: #f7fafc;
        border: none;
        color: #333333;
        padding: 6px;
        text-align: center;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .ui-datepicker-calendar .ui-state-default:hover {
        background-color: #e2e8f0;
        color: #333333;
    }

    .ui-datepicker-calendar .ui-state-active {
        background-color: #1a202c;
        border: none;
        color: #ffffff;
    }

    /* Style untuk form */
    .booking-form {
        background-color: #ffffff;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .booking-form label {
        font-size: 14px;
        font-weight: bold;
        color: #333333;
    }

    .booking-form input[type="text"],
    .booking-form input[type="date"],
    .booking-form select {
        width: 100%;
        padding: 8px;
        margin-top: 6px;
        margin-bottom: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    .booking-form input[type="text"]:focus,
    .booking-form input[type="date"]:focus,
    .booking-form select:focus {
        outline: none;
        border-color: #4a90e2;
    }

    .booking-form button[type="submit"] {
        background-color: #4a90e2;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    .booking-form button[type="submit"]:hover {
        background-color: #3672c4;
    }

    .booking-form a {
        color: #333333;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s ease;
    }

    .booking-form a:hover {
        color: #4a90e2;
    }
</style>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
<script>
    $(function() {
        $('#car_id').change(function() {
            var car_id = $(this).val();
            var cars = @json($cars);
            if (cars) {
                var selectedCar = cars.find(function(car) {
                    return car.id == car_id;
                });
                if (selectedCar) {
                    $('#brand').text(selectedCar.brand);
                    $('#type').text(selectedCar.type);
                    $('#price').text(selectedCar.price); // Update price without formatting
                    $('#license').text(selectedCar.license);
                    $('#car_image').attr('src', '/storage/' + selectedCar.image); // Update car image
                    calculateTotalPrice();
                }
            }
        });

        var durationDays = 0;

        function calculateDuration() {
            var startDate = $('#start_date').datepicker('getDate');
            var endDate = $('#end_date').datepicker('getDate');
            if (startDate && endDate) {
                var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
                durationDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                $('#duration').val(durationDays); // Update the duration input field
                calculateTotalPrice();
            }
        }

        function calculateTotalPrice() {
            var pricePerDay = parseFloat($('#price').text().replace(/[^\d.]/g,
                '')); // Remove non-digit characters
            if (!isNaN(pricePerDay) && !isNaN(durationDays)) {
                var totalPrice = pricePerDay * durationDays;
                $('#total_price').val(totalPrice.toFixed(
                    2)); // Update the total_price input field with the total price
            }
        }

        $("#start_date").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: 0,
            onSelect: function(selectedDate) {
                $("#end_date").datepicker("option", "minDate", selectedDate);
                calculateDuration();
            }
        });

        $("#end_date").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: 0,
            onSelect: function(selectedDate) {
                $("#start_date").datepicker("option", "maxDate", selectedDate);
                calculateDuration();
            }
        });
    });
</script>
