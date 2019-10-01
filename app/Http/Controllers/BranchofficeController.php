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
    public function index()
    {
        $branchoffices = branchoffice::OrderBy('created_at', 'DESC')->paginate(10);
        $city = city::all();
        $employee = employee::all();
        return view('pages.branchOffice.branchoffice', compact('branchoffices', 'employee', 'city'));
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
        $branchoffice = branchoffice::where("id", $id->id)->with(['vehicles','sales', 'city'])->get();
        return view('pages.branchoffice.profile', compact('branchoffice'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\branchoffice  $branchoffice
     * @return \Illuminate\Http\Response
     */
    public function destroy(branchoffice $branchoffice)
    {
        //
    }
}
