<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Rental') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-xl text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            @if (session('success'))
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                                    class="text-sm text-green-600 dark:text-green-400">{{ session('success') }}
                                </p>
                            @endif
                            @if (session('danger'))
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                                    class="text-sm text-red-600 dark:text-red-400">{{ session('danger') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Nama User
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama Mobil
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    License
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Durasi
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Total Price
                                </th>
                                <th scope="col" class="hidden px-6 py-3 md:block">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Gambar Mobil
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Bukti Pembayaran
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rentals as $rental)
                                <tr class="odd:bg-white odd:dark:bg-gray-800 even:bg-gray-50 even:dark:bg-gray-700">
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        @if ($rental->user)
                                            {{ $rental->user->name }}
                                        @endif
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        @if ($rental->car)
                                            {{ $rental->car->name }}
                                        @endif
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        @if ($rental->car)
                                            {{ $rental->car->license }}
                                        @endif
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        @if ($rental->car)
                                            {{ $rental->duration }} hari
                                        @endif
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        @if ($rental->car)
                                            {{ $rental->total_price }}
                                        @endif
                                    </td>
                                    <td class="hidden px-6 py-4 md:block">
                                        @if ($rental->is_completed == 1)
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                                Complete
                                            </span>
                                        @else
                                            <span
                                                class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                                Uncomplete
                                            </span>
                                        @endif
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        @if ($rental->car && $rental->car->image)
                                            <img src="{{ asset('storage/' . $rental->car->image) }}" alt="Car Image"
                                                class="w-auto h-12">
                                        @else
                                            No Image Available
                                        @endif
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        @if ($rental->proof_payment)
                                            <a href="{{ asset('storage/' . $rental->proof_payment) }}" target="_blank"
                                                class="text-blue-600 underline dark:text-blue-400">
                                                View Proof
                                            </a>
                                        @else
                                            No Proof Uploaded
                                        @endif
                                    </td>



                                    <td class="px-6 py-4">
                                        <div class="flex space-x-3">
                                            @if ($rental->is_completed == 0)
                                                <form action="{{ route('rental.complete', $rental) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-600 dark:text-green-400">
                                                        Complete
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('rental.uncomplete', $rental) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-blue-600 dark:text-blue-400">
                                                        Uncomplete
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('rental.destroy', $rental) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white dark:bg-gray-800">
                                    <td scope="row" colspan="9"
                                        class="px-6 py-4 font-medium text-center text-gray-900 dark:text-white">
                                        Empty
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($rentalsCompleted > 1)
                    <div class="p-6 text-xl text-gray-900 dark:text-gray-100">
                        <form action="{{ route('rental.deleteallcompleted') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-primary-button>
                                Delete All Completed Task
                            </x-primary-button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
