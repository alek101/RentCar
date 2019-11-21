<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontPageController extends Controller
{
    //stranica o nama
    function nama()
    {
        return view('klient.nama');
    }

    //stranica uslovi koriscenja
    function uslovi()
    {
        return view('klient.uslovi');
    }
}
