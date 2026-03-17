<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        return view('user-interface', [
            'user' => $request->user(),
            'token' => $request->user()->api_token,
        ]);
    }
}
