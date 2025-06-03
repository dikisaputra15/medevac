<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\Airport;
use App\Models\Embassiees;

class HomeController extends Controller
{
    public function index(Request $request)
    {
         $totalhospital = Hospital::count();
         $totalairport = Airport::count();
         $totalembassy = Embassiees::count();

        return view('pages.dashboard',
            [
                'totalhospital' => $totalhospital,
                'totalairport' => $totalairport,
                'totalembassy' => $totalembassy
            ]
        );
    }
}
