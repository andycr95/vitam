<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\payment;
use App\sale;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $payment = payment::orderBy('id', 'desc')->with('sale.client')->take(5)->get();
        $sale = sale::orderBy('id', 'desc')->with(['client', 'vehicle'])->take(5)->get();
        return view('home', compact('payment', 'sale'));
    }

}
