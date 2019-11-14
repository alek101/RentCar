<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontPageController extends Controller
{
    //
    function nama()
        {
            return view('klient.nama');
        }
}
