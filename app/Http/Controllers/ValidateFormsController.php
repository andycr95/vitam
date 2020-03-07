<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\employee;
use App\branchoffice;
use App\investor;
use App\client;
use App\payment;

class ValidateFormsController extends Controller
{
    public function ValidateEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'unique:users'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json("Ya existe un usuario con este correo.", 200);
        } else {
            return response()->json(true, 200);
        }
    }

    public function ValidateEmployeeBranchs(Request $request)
    {
        $branchs = employee::where('id', $request->id)->with('branch')->get();
        return response()->json($branchs, 200);
    }

    public function ValidateBranchs(Request $request)
    {
        $branchs = branchoffice::where('id', $request->id)->with('employees', 'vehicles')->get();
        return response()->json($branchs, 200);
    }

    public function ValidateInvestorVehicles(Request $request)
    {
        $investor = investor::where('id', $request->id)->with('vehicles')->get();
        return response()->json($investor, 200);
    }

    public function ValidateClientEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'unique:clients'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json("Ya existe un cliente con este correo.", 200);
        } else {
            return response()->json(true, 200);
        }
    }

    public function ValidateClientDocumento(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'documento' => 'unique:clients'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json("Ya existe un cliente con este documento.", 200);
        } else {
            return response()->json(true, 200);
        }
    }

    public function ValidateVehicle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'placa' => 'unique:vehicles',
            'chasis' => 'unique:vehicles',
            'motor' => 'unique:vehicles'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors, 200);
        } else {
            return response()->json(true, 200);
        }
    }

    public function ValidateClientSales(Request $request)
    {
        $client = client::where('clients.id', $request->id)->where('sales.state','1')->join('sales', 'sales.client_id', '=', 'clients.id')->get();
        return response()->json($client, 200);
    }

    public function ValidatePayment(Request $request)
    {
        $last_pay = payment::where('payments.vehicle_id',$request->id)->join('sales', 'sales.vehicle_id', 'payments.vehicle_id')
        ->select('payments.amount', 'payments.type','sales.fee')
        ->latest('payments.created_at')->first();
        return response()->json($last_pay, 200);
    }
}
