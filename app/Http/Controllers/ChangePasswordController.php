<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use App\User;

class ChangePasswordController extends Controller
{
    //vraca stranicu za izmenu lozinke
    public function changePassForm()
    {
        return view('klient.changePassword');
    }

    //menja lozinku
    public function changePassword(Request $request)
    {
        $request->validate([
            // 'current_password' => ['required', new MatchOldPassword],
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        if(Hash::check($request->current_password,auth()->user()->password))
        {
           User::findOrFail(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
   
            return back()->withErrors(['Šifra je uspešno promenjena!']); 
        }
        else
        {
            return back()->withErrors(['Trenutna lozinka se ne poklapa sa onom u bazi!']); 
        }
    }
}
