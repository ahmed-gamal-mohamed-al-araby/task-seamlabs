<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      //  $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function dashboard() {
        return view('dashboard');
    }

    public function getShipment(Request  $request) {
        $shipment = Shipment::where('shipment_number' , $request->shipment_number)->first();
        return  view('shipment' , compact('shipment'))->render();

    }
}
