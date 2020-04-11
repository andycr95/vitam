<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\payment;
use App\vehicle;
use App\sale;
use App\client;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $date = Carbon::now();
        $payment = payment::orderBy('id', 'desc')->with('sale.client')->take(5)->get();
        $sale = sale::orderBy('id', 'desc')->with(['client', 'vehicle'])->take(5)->get();
        $vehicles = vehicle::where('state','1')->get();
        $sales = DB::table('payments')->select(DB::raw('SUM(amount) as total_sales'))->where('type','pago')->get();
        $sales[0]->total_sales = "$ ".number_format($sales[0]->total_sales);
        $late_pays = $this->getLatePays();
        $salesMonth = DB::table('payments')->whereMonth('created_at', $date->month)->where('type','pago')->select(DB::raw('SUM(amount) as total_sales'))->get();
        $salesMonth[0]->total_sales = "$ ".number_format($salesMonth[0]->total_sales);
        return view('home', compact('payment', 'sale', 'vehicles', 'sales', 'salesMonth', 'late_pays'));;
    }

    public function getLatePays()
    {
        define('SECONDS_PER_DAY', 86400);
        $payments = array();
        $days_ago = date('Y-m-d', time() - 3 * SECONDS_PER_DAY);
        $clients = client::where('state','1')->get();
        for ($i=0; $i < $clients->count(); $i++) {
            $pago = payment::where('sales.state','1')->where('payments.type','pago')->where('clients.id',$clients[$i]->id)->where('payments.created_at', '<',$days_ago)
            ->join('sales', 'sales.id','payments.sale_id')->join('vehicles', 'vehicles.id','payments.vehicle_id')
            ->join('clients', 'clients.id','sales.client_id')->orderBy('payments.created_at', 'desc')->select('payments.created_at', 'payments.id as payment','vehicles.id as vehicle', 'clients.id as client')->limit(1)->get();
            if (!empty($pago)) {
                foreach ($pago as $pago) {
                    $p = payment::find($pago['payment']);
                    array_push($payments, $p);
                }
            }
        }
        return $payments;
    }
}
