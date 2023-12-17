<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use Illuminate\View\View;

use App\Models\User;

use App\Http\Controllers\ProductCartController;

function verifyNotAutenticated(): void
{
    if (Auth::check() || Auth::guard('admin')->check())
        abort(403);
}

class LoginController extends Controller
{
    public function showLoginForm()
    {
        verifyNotAutenticated();
        if (Auth::check()) {
            return redirect('/welcome');
        } else {
            return view('auth.login');
        }
    }

    public function authenticate(Request $request): RedirectResponse
    {
        verifyNotAutenticated();
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/admin');
        }

        $guestId = session('guestID');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            if (User::where('email', $credentials['email'])->first()->banned) {
                Auth::logout();
                return redirect('/login')->withErrors([
                    'password' => 'A sua conta foi banida.',
                ]);
            }

            if ($guestId) {
                ProductCartController::transferGuestCart($guestId);
                return redirect()->intended('/cart');
            }

            return redirect()->intended('/products');
        }

        return back()->withErrors([
            'email' => 'As credenciais introduzidas não correspodem aos nossos registos.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
