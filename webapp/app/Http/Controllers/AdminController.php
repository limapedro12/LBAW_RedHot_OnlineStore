<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Admin;

class AdminController extends Controller{

    public function admin(){
        return view('pages/admin');
    }

}