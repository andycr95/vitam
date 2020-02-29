<?php

namespace App\Http\Controllers;

use App\payment;
use App\sale;
use Illuminate\Http\Request;

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
    public function create()
    {
        //
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
        $payment = new payment();
        for ($i=0; $i < $sale->count(); $i++) {
            $pays = payment::where('sale_id', $sale[0]->id)->count();
        }
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
            }
        } else {
            for ($i=0; $i < $sale->count(); $i++) {
                $last_pay = payment::where('sale_id',$sale[0]->id)->latest()->first();
                if ($request->type == 'abono') {
                    if ($last_pay->type == 'abono') {
                        if (($last_pay->amount + $request->amount) >= $sale[0]->fee) {
                            $payment->counter = $last_pay->counter - 1;
                            $payment->type = "pago";
                            $payment->amount = $sale[0]->fee;
                        } else {
                            $payment->amount = $last_pay->amount + $request->amount;
                            $payment->counter = $last_pay->counter;
                            $payment->type = "abono";
                        }
                    } else {
                        $payment->counter = $last_pay->counter;
                        $payment->amount = $request->amount;
                        $payment->type = $request->type;
                    }
                } else {
                    $payment->counter = $last_pay->counter - 1;
                }
            }
        }

        $payment->vehicle_id = $request->vehicle_id;
        $payment->save();
        $payments = payment::where('sale_id',$sale[0]->id)->where('type', 'pago')->count();
        for ($i=0; $i < $sale->count(); $i++) {
            if ($payments == $sale[0]->amount) {
                $s = sale::find($sale[0]->id);
                $s->state = '0';
                $s->save();
            }
        }


        return redirect()->back()->with('success', $request->type.' registrado');;
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
