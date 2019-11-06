<?php

namespace App\Http\Controllers;

use App\sale;
use App\typeSale;
use App\vehicle;
use App\client;
use App\branchoffice;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = sale::where('status', '1')->paginate(10);
        $clients = client::where('status', '1')->get();
        $branchoffices = branchoffice::where('status', '1')->get();
        $vehicles = vehicle::where('status', '1')->get();
        $typeSales = typeSale::all();
        return view('pages.sales.sales', compact('sales', 'clients', 'branchoffices', 'vehicles', 'typeSales'));
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
        $typeSale = typeSale::where("id", $request->typesale_id)->get();
        $vehicle = vehicle::where("id", $request->vehicle_id)->with('type')->get();
        $amount = $this->Calculate($typeSale, $vehicle);
        
        $sale = new sale();
        $sale->branchoffice_id = $request->branchoffice_id;
        $sale->vehicle_id = $request->vehicle_id;
        $sale->typesale_id = $request->typesale_id;
        $sale->client_id = $request->client_id;
        $sale->date = now();
        $sale->amount = $amount;
        $sale->save();
        
        $vh = vehicle::find($request->vehicle_id);
        $vh->status = '0';
        $vh->save();
        return redirect()->back()->with('success','Venta realizada');
    }

    public function Calculate($typeSale, $vehicle)
    {
        for ($i=0; $i < $typeSale->count(); $i++) { 
            for ($j=0; $j < $vehicle->count() ; $j++) { 
                if ($vehicle[$j]->amount == 0) {
                    return round($vehicle[$j]->type->counter / $typeSale[$i]->amount);
                } else {
                    return round($vehicle[$j]->type->counter / $typeSale[$i]->amount);
                }
                
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(sale $sale)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(sale $sale)
    {
        //
    }
}
