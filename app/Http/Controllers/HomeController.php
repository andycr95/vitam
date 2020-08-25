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
        $vehicles = vehicle::where('state','1')->where('status','1')->get();
        $sales = DB::table('payments')->select(DB::raw('SUM(amount) as total_sales'))->where('type','pago')->get();
        $sales[0]->total_sales = "$ ".number_format($sales[0]->total_sales);
        $late_pays = $this->getLatePays();
        $salesMonth = DB::table('payments')->whereMonth('created_at', $date->month)->where('type','pago')->select(DB::raw('SUM(amount) as total_sales'))->get();
        $t = $this->getMonth();
        $salesMonth[0]->total_sales = "$ ".number_format($salesMonth[0]->total_sales);
        return view('home', compact('payment', 'sale', 'vehicles', 'sales', 'salesMonth', 'late_pays', 't'));
    }

    public function getMonth()
    {
        setlocale(LC_TIME, 'es_ES.UTF-8');
        $date = Carbon::now();
        $clients = DB::select('select clients.name, clients.last_name, sales.id as sale_id, clients.id as client_id, SUM(payments.amount) as Total, payments.type, vehicles.id as vehicle_id, vehicles.investor_id from clients join sales on sales.client_id=clients.id join payments on payments.sale_id=sales.id join vehicles on vehicles.id=sales.vehicle_id where payments.type="pago" and MONTH(payments.created_at) = ? GROUP BY sales.id', [$date->month]);
        $total= 0;
        $totalv= 0;
        $client2 = DB::select('select clients.name, clients.last_name, sales.id as sale_id, clients.id as client_id, SUM(payments.amount) as Total, payments.type, vehicles.id as vehicle_id, vehicles.investor_id from clients join sales on sales.client_id=clients.id join payments on payments.sale_id=sales.id join vehicles on vehicles.id=sales.vehicle_id where payments.type="abono" and MONTH(payments.created_at) = ? GROUP BY sales.id', [$date->month]);
        for ($i=0; $i < count($clients); $i++) { 
            for ($j=0; $j < count($client2); $j++) { 
                if ($clients[$i]->sale_id == $client2[$j]->sale_id) {
                    array_splice($client2, $j, 1);
                }
            }
        }
        for ($i=0; $i < count($client2); $i++) { 
            array_push($clients, $client2[$i]);
        }
        for ($i=0; $i < count($clients); $i++) { 
            if ($clients[$i]->type == 'pago') {
                DB::statement('SET lc_time_names = "es_CO"');
                $py = DB::select('select  DATE_FORMAT(created_at, "%d %M") as cr from payments where type="pago" and sale_id= ? and MONTH(payments.created_at) = ? order by created_at desc limit 1;', [$clients[$i]->sale_id, $date->month]);
                $l_py = DB::select('select * from payments where sale_id= ? and MONTH(payments.created_at) = ? order by created_at desc limit 1;', [$clients[$i]->sale_id, $date->month]);
                $f_py = DB::select('select * from payments where type="pago" and sale_id= ? and MONTH(payments.created_at) = ? order by created_at asc limit 1;', [$clients[$i]->sale_id, $date->month]);
                $f_py[0]->l_counter = ($f_py[0]->counter + 1);
                $a_py = DB::select('select * from payments where type="abono" and sale_id= ? and counter= ? and MONTH(payments.created_at) < ?;', [$clients[$i]->sale_id, $f_py[0]->l_counter, $date->month]);
                $clients[$i]->date_end = $py[0]->cr;
                if ($l_py[0]->type == 'abono') {
                    $clients[$i]->Total += $l_py[0]->amount;
                }
                if (count($a_py) > 0) {
                    $clients[$i]->Total -= $a_py[count($a_py) - 1]->amount;
                }
            }
            if ($clients[$i]->investor_id == 1) {
                $totalv += $clients[$i]->Total;
            }
            $total += $clients[$i]->Total;           
        }
        $t = "$ ".number_format($total);
        return $t;
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
