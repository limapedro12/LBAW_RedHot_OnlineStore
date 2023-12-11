<?php
  
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use Illuminate\View\View;

use App\Models\User;

use App\Http\Controllers\ProductCartController;

function verifyNotAutenticated() : void {
    if(Auth::check() || Auth::guard('admin')->check())
        abort(403);
}

class LoginController extends Controller
{

    /**
     * Display a login form.
     */
    public function showLoginForm()
    {
        verifyNotAutenticated();
        if (Auth::check()) {
            return redirect('/welcome');
        } else {
            return view('auth.login');
        }
    }

    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        verifyNotAutenticated();
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (User::where('email', $credentials['email'])->first()->banned) {
            return back()->withErrors([
                'email' => 'A sua conta foi banida.',
            ])->onlyInput('email');
        }
 
        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
 
            return redirect()->intended('/admin');
        }

        $guestId = session('guestID');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            if ($guestId) {
                ProductCartController::transferGuestCart($guestId);
                return redirect()->intended('/cart');
            }
 
            return redirect()->intended('/products');
        }
 
        return back()->withErrors([
            'email' => 'As credenciais dadas não correspodem ao nossos registos.',
        ])->onlyInput('email');
    }

    /**
     * Log out the user from application.
     */
    public function logout(Request $request)
    {
        //verifyNotAutenticated();
        Auth::logout();
        //Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')
            ->withSuccess('Logout efetuado com sucesso!');
    } 
}
