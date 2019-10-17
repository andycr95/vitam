<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateFormsController extends Controller
{
    public function ValidateEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'unique:users'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return "Ya existe un usuario con este correo.";
        } else {
            return true;
        }
    }
}
