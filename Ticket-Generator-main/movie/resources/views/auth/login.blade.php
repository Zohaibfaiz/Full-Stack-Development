<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-white">Welcome Back</h2>
        <p class="text-sm text-gray-400">Sign in to continue</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label class="block font-medium text-sm text-gray-400 mb-1" for="email">Email</label>
            <input id="email" class="block w-full rounded-md form-input px-3 py-2 shadow-sm" type="email" name="email" :value="old('email')" required autofocus placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-400 mb-1" for="password">Password</label>
            <input id="password" class="block w-full rounded-md form-input px-3 py-2 shadow-sm" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded bg-gray-900 border-gray-700 text-red-600 shadow-sm focus:ring-red-600" name="remember">
                <span class="ms-2 text-sm text-gray-400">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-gray-400 hover:text-white transition-colors" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out shadow-lg">
                Log In
            </button>
        </div>

        <div class="mt-6 text-center border-t border-gray-700 pt-4">
            <p class="text-sm text-gray-400">
                New here? <a href="{{ route('register') }}" class="text-red-500 hover:text-red-400 font-bold hover:underline">Create an account</a>
            </p>
        </div>
    </form>
</x-guest-layout>