<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PinController extends Controller
{
    //
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pin' => 'required|digits:5',
        ]);

        $pin = $request->input('pin');


        return view('pin', ['pin' => $pin]);
    }

}
