<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'buyer', // Default role for new registrations
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on user role
        return redirect($this->redirectPath($user));
    }

    /**
     * Get the redirect path based on user role.
     */
    protected function redirectPath($user): string
    {
        return match ($user->role) {
            'admin' => route('admin.dashboard', absolute: false),
            'seller' => route('seller.dashboard', absolute: false),
            'buyer' => route('home', absolute: false),
            default => route('home', absolute: false),
        };
    }
}
