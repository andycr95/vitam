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
            $payments = payment::search($buscar)->paginate(10);
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
        $payment->vehicle_id = $request->vehicle_id;
        $payment->type = $request->type;
        $payment->save();
        $payments = payment::where('vehicle_id', $request->vehicle_id)->count();
        for ($i=0; $i < $sale->count(); $i++) {
            if ($payments == $sale[0]->amount) {
                $s = sale::find($sale[0]->id);
                $s->state = 0;
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
