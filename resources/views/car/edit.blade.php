<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Edit Nama Mobil') }}
        </h2>
    </x-slot>

    <div class="sm:py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white dark:bg-gray-800 sm:shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="post" action="{{ route('car.update', $car) }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')



                        <!-- Other input fields for editing car details -->
                        <div class="mb-6">
                            <x-input-label for="name" :value="__('Nama Mobil')" />
                            <x-text-input id="name" name="name" type="text" class="block w-full mt-1"
                                :value="old('name', $car->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div class="mb-6">
                            <x-input-label for="brand" :value="__('Brand Mobil')" />
                            <x-text-input id="brand" name="brand" type="text" class="block w-full mt-1"
                                :value="old('brand', $car->brand)" required autofocus autocomplete="brand" />
                            <x-input-error class="mt-2" :messages="$errors->get('brand')" />
                        </div>
                        <div class="mb-6">
                            <x-input-label for="type" :value="__('Tipe Mobil')" />
                            <x-text-input id="type" name="type" type="text" class="block w-full mt-1"
                                :value="old('type', $car->type)" required autofocus autocomplete="type" />
                            <x-input-error class="mt-2" :messages="$errors->get('type')" />
                        </div>
                        <div class="mb-6">
                            <x-input-label for="license" :value="__('Plat Nomor')" />
                            <x-text-input id="license" name="license" type="text" class="block w-full mt-1"
                                :value="old('license', $car->license)" required autofocus autocomplete="license" />
                            <x-input-error class="mt-2" :messages="$errors->get('license')" />
                        </div>
                        <div class="mb-6">
                            <x-input-label for="price" :value="__('Harga')" />
                            <x-text-input id="price" name="price" type="text" class="block w-full mt-1"
                                :value="old('price', $car->price)" required autofocus autocomplete="price" />
                            <x-input-error class="mt-2" :messages="$errors->get('price')" />
                        </div>

                        <!-- Display current image if exists -->
                        <div class="mb-6">
                            @if ($car->image)
                                <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}"
                                    class="object-cover w-20 h-20 rounded-lg">
                            @else
                                <span>No Image</span>
                            @endif
                        </div>

                        <!-- Input for uploading new image -->
                        <div class="mb-6">
                            <x-input-label for="image" :value="__('Upload Gambar')" />
                            <input id="image" name="image" type="file" accept="image/*"
                                class="block w-full mt-1" />
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>

                        <!-- Save and Cancel Buttons -->
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                            <x-cancel-button href="{{ route('car.index') }}" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
