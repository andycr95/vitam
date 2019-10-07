<?php

namespace App\Http\Controllers;

use App\branchoffice;
use App\city;
use App\employee;
use Illuminate\Http\Request;

class BranchofficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        if ($request->buscar != '') {
            $buscar = $request->buscar;
            $branchoffices = branchoffice::search($buscar)->where('status', '1')->paginate(10);
        } else {
            $branchoffices = branchoffice::where('status', '1')->OrderBy('created_at', 'DESC')->paginate(10);
        }
        
        $city = city::all();
        $employees = employee::all();
        return view('pages.branchoffice.branchoffice', compact('branchoffices', 'city', 'employees'));
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
        $branchoffice = branchoffice::create($request->all());
        return redirect()->back()->with('info','Sucursal guardada');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\branchoffice  $branchoffice
     * @return \Illuminate\Http\Response
     */
    public function show(branchoffice $id)
    {
        $branchoffice = branchoffice::where("id", $id->id)->with(['vehicles','sales', 'city', 'employee', 'employees'])->get();
        $cities = city::all();
        $employees = employee::all();
        return view('pages.branchoffice.profile', compact('branchoffice', 'cities', 'employees'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\branchoffice  $branchoffice
     * @return \Illuminate\Http\Response
     */
    public function edit(branchoffice $branchoffice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\branchoffice  $branchoffice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, branchoffice $branchoffice)
    {
        $branchoffice = branchoffice::find($request->id);
        $branchoffice->name = $request->first_name;
        $branchoffice->employee_id = $request->encargado;
        $branchoffice->address = $request->address;
        $branchoffice->city_id = $request->city;
        $branchoffice->save();
        return redirect()->back()->with('success','Sucursal actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\branchoffice  $branchoffice
     * @return \Illuminate\Http\Response
     */
    public function destroy(request $request)
    {
        $branchoffice = branchoffice::find($request->id);
        $branchoffice->status = '0';
        $branchoffice->save();
        return redirect()->back()->with('success','Sucursal eliminado');
    }
}
