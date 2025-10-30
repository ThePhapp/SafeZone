<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlertUserController extends Controller
{
    //
    public function index()
    {
        
        return view('user.alerts.index');
    }
}
