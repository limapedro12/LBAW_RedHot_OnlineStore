<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\View\View;

use App\Models\User;


function verifyNotAutenticated() : void {
    if(Auth::check() || Auth::guard('admin')->check())
        abort(403);
}

class RegisterController extends Controller
{
    /**
     * Display a login form.
     */
    public function showRegistrationForm(): View
    {
        verifyNotAutenticated();
        return view('auth.register');
    }

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {   

        verifyNotAutenticated();
        $request->validate([
            'nome' => 'required|string|max:256',
            'email' => 'required|email|max:256|unique:utilizador',
            'password' => 'required|min:8|confirmed'
        ]);

        $newUser = User::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect('/login')
            ->withSuccess('You have successfully registered!');
    }
}
