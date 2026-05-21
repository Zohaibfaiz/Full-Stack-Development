<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Forgot Password?</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
            {{ __('No problem. Just let us know your email address and we will email you a password reset link.') }}
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="email">
                {{ __('Email') }}
            </label>
            <input id="email" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 shadow-sm px-4 py-2" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-lg shadow-red-900/50">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>
</x-guest-layout>