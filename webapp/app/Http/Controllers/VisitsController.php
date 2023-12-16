<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Visit;

class VisitsController extends Controller
{

    public function listVisits()
    {

        $visits = Visit::all();

        return view('pages.visits', [
            'visits' => $visits
        ]);
    }

    public function addVisit($ip_address)
    {

        $visit = new Visit();

        $visit->ip_address = $ip_address;
        $visit->timestamp = now();

        $visit->save();

        return redirect()->back();

    }

    public function removeVisit($id)
    {

        $visit = Visit::where('id', $id)->first();

        $visit->delete();

        return redirect()->back();
    }

    public function getIp()
    {

        $ip_address = $_SERVER['REMOTE_ADDR'];

        return $ip_address;
    }

    public function getNumberOfVisitsInLast30Days()
    {

        $visits = Visit::where('timestamp', '>', now()->subDays(30))->get();

        return $visits->count();
    }
}