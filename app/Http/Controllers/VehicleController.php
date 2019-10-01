<?php

namespace App\Http\Controllers;

use App\vehicle;
use App\investor;
use App\type;
use App\branchoffice;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = vehicle::where('status','activo')->OrderBy('created_at', 'DESC')->paginate(10);
        $investors = investor::all();
        $types = type::all();
        $branchoffices = branchoffice::all();
        return  view('pages.vehicles.vehicles', compact('vehicles', 'investors', 'types', 'branchoffices'));
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
        $vehicle = vehicle::create($request->all());
        return redirect()->back()->with('success','Vehiculo registrado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(vehicle $id)
    {
        $vehicle = vehicle::where('id',$id->id)->with(['investor', 'type', 'branchoffice'])->get();
        return  view('pages.vehicles.profile', compact('vehicles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, vehicle $vehicle)
    {
        $vehicle = vehicle::find($request->id);
        $vehicle->placa = $request->placa;
        $vehicle->model = $request->model;
        $vehicle->color = $request->color;
        $vehicle->chasis = $request->chasis;
        $vehicle->motor = $request->motor;
        $vehicle->investor_id = $request->investor_id;
        $vehicle->type_id = $request->type_id;
        $vehicle->branchoffice_id = $request->branchoffice_id;
        $vehicle->save();
        return redirect()->back()->with('success','Vehiculo actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $vehicle = vehicle::find($request->id);
        $vehicle->status = 'inactivo';
        $vehicle->save();
        return redirect()->back()->with('info','Vehiculo eliminado');
    }
}
