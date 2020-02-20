<?php

namespace App\Http\Controllers;

use App\investor;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class InvestorController extends Controller
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
            $investors = investor::where('state', '1')->join('users', function ($join) use ($buscar) {
                $join->on('users.id', '=', 'investors.user_id')
                    ->where('users.name', 'like', '%'.$buscar.'%');
            })->with(['vehicles'])->paginate(10);
        } else {
            $investors = investor::where('state', '1')->where('id', '!=', '1')->with(['vehicles', 'user'])->paginate(10);
        }
        return view('pages.investors.investors', compact('investors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInvestors()
    {
        $investors = investor::where('investors.state','1')->where('investors.id','!=','1')->join('users', 'users.id', '=', 'investors.user_id')->select('investors.id', 'users.name', 'users.last_name')->get();
        return response()->json($investors, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->last_name = $request->lname;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $photo = $request->file('photo')->store('public/avatars');
        $user->photo = str_replace('public/' , '' , $photo);
        $user->save();
        $investor = new investor();
        $investor->user_id = $user->id;
        $investor->save();
        return redirect()->back()->with('success','Inversionista guardado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\investor  $investor
     * @return \Illuminate\Http\Response
     */
    public function show(investor $id)
    {
        $investor = investor::where("id", $id->id)->with(['vehicles','user'])->get();
        return view('pages.investors.profile', compact('investor'));
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
        $user = User::find($request->id);
        $user->name = $request->first_name;
        $user->last_name = $request->last_name;
        if ($request->password != null) {
            $user->password = Hash::make($request->password);
        }
        $user->email = $request->email;
        $user->address = $request->address;
        $user->save();
        $investor = investor::find($request->idinvestor);
        if ($request->branchoffice_id != '') {
            $investor->branchoffice_id = $request->branch;
        }
        $investor->save();
        return redirect()->back()->with('success','Inversionista actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\investor  $investor
     * @return \Illuminate\Http\Response
     */
    public function destroy(request $request)
    {
        $investor = investor::find($request->iddelete);
        $investor->state = '0';
        $investor->save();
        return redirect()->back()->with('success','Inversionista eliminado');
    }
}
