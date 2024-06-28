<x-guest-layout>
    <div
        class="flex flex-col items-center min-h-screen px-4 pt-6 bg-gray-100 sm:px-0 sm:justify-center sm:pt-0 dark:bg-gray-900">
        <div
            class="w-full px-6 py-4 mt-6 overflow-hidden bg-white rounded-lg shadow-md sm:max-w-sm dark:bg-gray-800 sm:rounded-lg">
            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" novalidate>
                @csrf

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required
                        autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex justify-end mt-4">
                    <x-primary-button>
                        {{ __('Confirm') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

</x-guest-layout>
