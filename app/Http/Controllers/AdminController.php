<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserModel;

class AdminController extends Controller
{
    //
    public function home()
    {
        $users=UserModel::all();
        return view('admin.home',['users'=>$users]);
    }

    //
    public function formaRole($id)
    {
        $users=UserModel::where('id',$id)->firstOrFail();
        if($users->role<100)
        {
           return view('admin.forma',['users'=>$users]); 
        }
        else
        {
            return $this->home();
        }
    }

    //
    public function change(Request $request)
    {
        $id=$request->id;

        $user=UserModel::findOrFail($id);

        if($user->role<100)
        {
            $user->name=$request->name;
            $user->email=$request->meil;

            $role=$request->role;
            if($role>=100)
            {
                $role=99;
            }

            $user->role=$role;
            $user->save();
        }

        return $this->home();
    }

    //
    public function delete($id)
    {
        $user=UserModel::findOrFail($id);
        if($user->role<100)
        {
          $user->delete();  
        }
        
        return $this->home();
    }
}
