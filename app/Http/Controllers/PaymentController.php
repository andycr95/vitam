<?php

namespace App\Http\Controllers;

use App\payment;
use App\sale;
use App\client;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->buscar != '') {
            $buscar = $request->buscar;
            $payments = payment::join('vehicles', function($join) use ($buscar){
               $join->on('vehicles.id', '=', 'payments.vehicle_id')
               ->where('vehicles.placa', 'like', '%'.$buscar.'%');
            })->select('vehicles.*', 'payments.*','vehicles.amount as vehicles_amount')->OrderBy('payments.created_at', 'DESC')->paginate(10);
        } else {
            $payments = payment::OrderBy('created_at', 'DESC')->paginate(10);
        }

        $sales = sale::where('state','1')->get();
        return  view('pages.payments.payments', compact('payments', 'sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_late()
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

        return  view('pages.payments.late-payments', compact('payments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sale = sale::where('vehicle_id', $request->vehicle_id)->get();
        for ($i=0; $i < $sale->count(); $i++) {
            $pays = payment::where('sale_id', $sale[0]->id)->count();
        }
        $payment = new payment();
        if (!$request->amount) {
            for ($i=0; $i < $sale->count(); $i++) {
                $payment->amount = $sale[0]->fee;
            }
        }else {
            $payment->amount = $request->amount;
        }
        for ($i=0; $i < $sale->count(); $i++) {
            $payment->sale_id = $sale[0]->id;
        }
        if ($pays == 0) {
            for ($i=0; $i < $sale->count(); $i++) {
                $payment->counter = $sale[0]->amount - 1;
                $payment->type = $request->type;
                $payment->vehicle_id = $request->vehicle_id;
                $payment->save();
            }
        } else {
            for ($i=0; $i < $sale->count(); $i++) {
                $last_pay = payment::where('sale_id',$sale[0]->id)->latest()->first();
                if ($request->type == 'abono') {
                    if ($last_pay->type == 'abono') {
                        if (($last_pay->amount + $request->amount) == $sale[0]->fee) {
                            $payment->counter = $last_pay->counter - 1;
                            $payment->type = "pago";
                            $payment->amount = $sale[0]->fee;
                            $payment->vehicle_id = $request->vehicle_id;
                            $payment->save();
                        } else {
                            $payment->amount = $last_pay->amount + $request->amount;
                            $payment->counter = $last_pay->counter;
                            $payment->type = "abono";
                            $payment->vehicle_id = $request->vehicle_id;
                            $payment->save();
                        }
                    } else {
                        if ($request->amount > $sale[0]->fee) {
                            $loop = ($request->amount / $sale[0]->fee);
                            $whole = floor($loop);
                            $fraction = $loop - $whole;
                            $ok = 0;
                            for ($i=0; $i < $whole; $i++) { 
                                sleep(1);
                                $this->MakePay($request, $last_pay, $sale[0]->id);
                                $ok += 1;

                            }
                            if ($ok == $whole && $fraction > 0.01) {
                                sleep(1);
                                $last_pay2 = payment::where('sale_id',$sale[0]->id)->latest()->first();
                                $payment->counter = $last_pay2->counter;
                                $payment->amount = ($sale[0]->fee * $fraction);
                                $payment->type = $request->type;
                                $payment->vehicle_id = $request->vehicle_id;
                                $payment->save();
                            }
                        }  else {
                            $payment->counter = $last_pay->counter;
                            $payment->amount = $request->amount;
                            $payment->type = $request->type;
                            $payment->vehicle_id = $request->vehicle_id;
                            $payment->save();
                        }
                        
                    }
                } else {
                    $payment->counter = $last_pay->counter - 1;
                    $payment->vehicle_id = $request->vehicle_id;
                    $payment->save();
                }
            }
        }

        $payments = payment::where('sale_id',$sale[0]->id)->where('type', 'pago')->count();
        for ($i=0; $i < $sale->count(); $i++) {
            if ($payments == $sale[0]->amount) {
                $s = sale::find($sale[0]->id);
                $s->state = '0';
                $s->save();
            }
        }


        return redirect()->back()->with('success', $request->type.' registrado');
    }

    public function MakePay($pay, $last_pay, $sale_id)
    {
        $last_pay = payment::where('sale_id',$sale_id)->latest()->first();
        $payment = new payment();
        $payment->amount = $last_pay->amount;
        $payment->vehicle_id = $pay->vehicle_id;
        $payment->sale_id = $sale_id;
        $payment->counter = $last_pay->counter - 1;
        $payment->created_at = Carbon::now();
        $payment->updated_at = Carbon::now();
        $payment->type = 'pago';
        $payment->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(payment $payment)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(payment $payment)
    {
        //
    }
}

