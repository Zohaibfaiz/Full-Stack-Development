<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

/**
 * Class AuthController
 *
 * Handles user authentication including registration and login. Since this
 * project does not rely on Laravel Breeze or Jetstream, authentication
 * features are implemented manually.
 */
class AuthController extends Controller
{
    /**
     * Display the registration form.
     */
    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:student,teacher,admin'],
            'registration_number' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'registration_number' => $validated['registration_number'] ?? null,
        ]);

        // After registration, ask the user to log in explicitly (no auto-login).
        return redirect()->route('login')->with('message', 'Account created successfully. Please log in to continue.');
    }

    /**
     * Display the login form.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended($this->redirectBasedOnRole(Auth::user()));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Determine the redirect path based on the user's role.
     */
    protected function redirectBasedOnRole(User $user): string
    {
        return match ($user->role) {
            'teacher' => route('teacher.dashboard'),
            'admin' => route('admin.dashboard'),
            default => route('student.dashboard'),
        };
    }
}
