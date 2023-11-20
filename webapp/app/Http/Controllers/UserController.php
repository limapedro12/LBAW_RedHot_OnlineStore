<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function showProfileDetails(int $id) : View
    {
        $user = User::findOrFail($id);

        $this->authorize('respectiveUserOrAdmin', $user);

        return view('pages.user', [
            'user' => $user
        ]);
    }

    public function editProfileForm(int $id) : View
    {
        $user = User::findOrFail($id);

        $this->authorize('respectiveUserOrAdmin', $user);

        return view('pages.editProfile', [
            'user' => $user
        ]);
    }

    public function editProfile(Request $request, int $id)
    {
        $user = User::findOrfail($id);

        $this->authorize('respectiveUserOrAdmin', $user);

        if ($user->password != Hash::make($request->password)) {
            return redirect('/users/'.$id.'/edit');
        }

        $request->validate([
            'nome' => 'required|string|max:256',
            'email' => 'required|email|max:256|unique:utilizador',
        ]);

        User::where('id', '=', $id)->update(array('nome' => $request->nome, 'email' => $request->email));

        return redirect('/users/'.$id);
    }

    public function destroy(User $user)
    {

        $this->authorize('respectiveUserOrAdmin', $user); 
        $card->delete();
    }
}

