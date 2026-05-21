<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-white">Create Account</h2>
        <p class="text-sm text-gray-400">Join MovieBooker today</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label class="block font-medium text-sm text-gray-400 mb-1" for="name">Full Name</label>
            <input id="name" class="block w-full rounded-md form-input px-3 py-2 shadow-sm" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
        </div>

        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-400 mb-1" for="email">Email</label>
            <input id="email" class="block w-full rounded-md form-input px-3 py-2 shadow-sm" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-400 mb-1" for="password">Password</label>
            <input id="password" class="block w-full rounded-md form-input px-3 py-2 shadow-sm" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-400 mb-1" for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" class="block w-full rounded-md form-input px-3 py-2 shadow-sm" type="password" name="password_confirmation" required />
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out shadow-lg">
                Register
            </button>
        </div>

        <div class="mt-6 text-center border-t border-gray-700 pt-4">
            <p class="text-sm text-gray-400">
                Already have an account? <a href="{{ route('login') }}" class="text-red-500 hover:text-red-400 font-bold hover:underline">Log in</a>
            </p>
        </div>
    </form>
</x-guest-layout>