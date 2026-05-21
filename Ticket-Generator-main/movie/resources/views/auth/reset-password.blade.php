<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Reset Password</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Enter your new credentials</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="email">
                {{ __('Email') }}
            </label>
            <input id="email" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 shadow-sm px-4 py-2" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="password">
                {{ __('Password') }}
            </label>
            <input id="password" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 shadow-sm px-4 py-2" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="password_confirmation">
                {{ __('Confirm Password') }}
            </label>
            <input id="password_confirmation" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 shadow-sm px-4 py-2"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-lg shadow-red-900/50">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>