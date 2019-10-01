<?php

namespace App\Http\Controllers;

use App\investor;
use Illuminate\Http\Request;

class InvestorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $investors = investor::with(['vehicles.payments', 'user'])->paginate(10);
        return view('pages.investors.investors', compact('investors'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\investor  $investor
     * @return \Illuminate\Http\Response
     */
    public function show(investor $investor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\investor  $investor
     * @return \Illuminate\Http\Response
     */
    public function edit(investor $investor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\investor  $investor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, investor $investor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\investor  $investor
     * @return \Illuminate\Http\Response
     */
    public function destroy(investor $investor)
    {
        //
    }
}
