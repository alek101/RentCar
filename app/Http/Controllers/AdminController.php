<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserModel;

class AdminController extends Controller
{
    //
    public function home()
    {
        // $users=UserModel::all();
        $users=UserModel::orderBy('role','desc')->get();
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
    public function changeUser()
    {
        return view('klient.changeUser');
    }

    //
    public function madeChangeUser(Request $request)
    {
        $id=$request->id;
        $user=UserModel::findOrFail($id);

        $user->name=$request->name;
        $user->email=$request->email;
        $user->phone=$request->phone;

        $user->saveOrFail();
        return redirect('/home');
    }

    //
    public function delete($id)
    {
        $user=UserModel::findOrFail($id);
        if($user->role<100)
        {
          $user->delete();  
        }
        
        return redirect('/admin');
    }

    //
    public function getFormImage()
    {
        return view('baza.formImage');
    }

    public function uploadImage(Request $request)
    {
        //proverava da li je name::image slika
        $request->validate([
            'slika' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
  
        //dodajemo ime slike i extenziju
        // $imageName = $request->nazivSlike.'.'.$request->slika->extension(); 

        //dodajemo ime slike bez ekstenzije
        $imageName = $request->nazivSlike; 
   
        //preuzima sliku i ubacuje je u fajl images
        $request->slika->move(public_path('images'), $imageName);
   
        return back()
            ->with('success','You have successfully upload image.')
            ->with('image',$imageName);
    }

    //original code:: change name of incoming picture with img
    // public function uploadImage(Request $request)
    // {
    //     //proverava da li je name::image slika
    //     $request->validate([
    //         'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);
  
    //     //dodajemo ime slike i extenziju
    //     $imageName = $request->nazivSlike.'.'.$request->image->extension(); 
   
    //     //preuzima sliku i ubacuje je u fajl images
    //     $request->image->move(public_path('images'), $imageName);
   
    //     return back()
    //         ->with('success','You have successfully upload image.')
    //         ->with('image',$imageName);
    // }

    

}
