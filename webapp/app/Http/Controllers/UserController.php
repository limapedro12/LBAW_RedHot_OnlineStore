<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

use App\Http\Controllers\FileController;

function verifyUser(User $user) : void {
    if((Auth::user()==null || Auth::user()->id != $user->id) && Auth::guard('admin')->user()==null)
        abort(403);
}

function verifyToken(User $user, string $token) {

    $validTokens = session('validTokens');

    if($token == null || $token == "" || strlen($token) != 64 || !in_array($token, $validTokens) || $user->id != array_search($token, $validTokens))
        abort(403);
}

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

        verifyUser($user);

        return view('pages.user', [
            'user' => $user,
            'totalOrders' => $this->getTotalOrders($id),
            'totalReviews' => $this->getTotalReviews($id),
            'orders' => $this->getOrders($id),
            'unreadNotifications' => $this->getNumberOfUreadNotifications($id)
        ]);
    }

    public function editProfileForm(int $id) : View
    {
        $user = User::findOrFail($id);

        verifyUser($user);

        return view('pages.editUser', [
            'user' => $user
        ]);
    }

    public function editProfile(Request $request, int $id)
    {
        $user = User::findOrfail($id);

        verifyUser($user);

        if ($request->password !== $request->password_confirmation)
            return back()->withErrors(['password' => 'As passwords introduzidas não coincidem']);

        if (!Hash::check($request->password, $user->password)) 
            return back()->withErrors(['password' => 'A password introduzida não corresponde à sua password atual']);

        $request->validate([
            'nome' => 'required|string|max:256',
            'email' => 'required|email|max:256',
        ]);

        if ($request->email != $user->email) {
            $request->validate([
                'email' => 'unique:utilizador',
            ]);
        }

        if ($request->file && !($request->deletePhoto)) {
            $fileController = new FileController();
            $hash = $fileController->upload($request, 'profile', $id);
            User::where('id', '=', $id)->update(array('profile_image' => $hash));
        } else if ($request->deletePhoto) {
            User::where('id', '=', $id)->update(array('profile_image' => null));
        }

        User::where('id', '=', $id)->update(array('nome' => $request->nome, 'email' => $request->email));

        return redirect('/users/'.$id);
    }

    public function deleteAccountForm(int $id) : View
    {
        $user = User::findOrFail($id);

        $this->authorize('deleteAccount', $user);

        return view('pages.delete_account', [
            'user' => $user
        ]);
    }

    public function deleteAccount(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        $this->authorize('deleteAccount', $user);

        if (!Hash::check($request->password, $user->password)) {
            return redirect('/users/'.$id.'/delete_account');
        }

        User::where('id', '=', $id)->delete();

        return redirect('/logout');
    }

    // edit password version
    public function editPasswordForm(Request $request, int $id) : View
    {
        $user = User::findOrFail($id);

        return view('pages.editPassword', [
            'user' => $user,
        ]);
    }

    // edit password version
    public function editPassword(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'new_password' => 'required|min:8',
        ]);

        if (!Hash::check($request->old_password, $user->old_password)) 
            return back()->withErrors(['password' => 'A sua password atual está incorreta']);

        if ($request->new_password !== $request->new_password_confirmation)
            return back()->withErrors(['password_confirmation' => 'As passwords introduzidas não coincidem']);

        User::where('id', '=', $id)->update(array('password' => Hash::make($request->new_password)));

        return redirect('/users/'.$id);
    }

    // forgot password version
    public function changePasswordForm(Request $request, int $id, string $token) : View
    {
        $user = User::findOrFail($id);

        verifyToken($user, $token);

        return view('pages.changePassword', [
            'user' => $user,
            'token' => $token
        ]);
    }

    // forgot password version
    public function changePassword(Request $request, int $id, string $token)
    {
        $user = User::findOrFail($id);

        verifyToken($user, $token);

        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        User::where('id', '=', $id)->update(array('password' => Hash::make($request->password)));

        return redirect('/login');
    }

    public function getTotalOrders(int $id) : int
    {
        $user = User::findOrFail($id);

        verifyUser($user);

        return $user->orders()->count();
    }

    public function getTotalReviews(int $id) : int
    {
        $user = User::findOrFail($id);

        verifyUser($user);

        return $user->totalReviews();
    }

    public function getOrders(int $id)
    {
        $user = User::findOrFail($id);

        verifyUser($user);

        return $user->orders()->get();
    }

    public function getNumberOfUreadNotifications(int $id) : int
    {
        $user = User::findOrFail($id);

        verifyUser($user);

        return $user->getNumberOfUreadNotifications();
    }
}
