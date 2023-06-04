<?php

namespace App\Http\Controllers;

use App\Models\Museum;
use App\Models\JenisMuseum;
use App\Models\Koleksi;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class AdminController extends Controller
{
    public function actionlogin(){
        $credentials = request()->validate([
            'name' => 'required',
            'password' => 'required',
        ]);
        // dd(Auth::attempt($credentials));

        if (Auth::attempt($credentials)){
            return redirect('/admin/dashboard');
        }else{
            Session::flash('error', 'Username atau Password Salah');
            return redirect('/login');
        }
    }
    
    public function login()
    {
        if (Auth::check()) {
            return redirect('/admin/dashboard');
        }else{
            return view('auth.login');
        }
    }


    public function actionlogout()
    {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard',[
            "spaces" => Museum::all(),
            "spaces_count" => Museum::all()->count(),  
            "jenis_count" => JenisMuseum::all()->count(),  
            "galeri_count" => Galeri::all()->count(),  
            "koleksi_count" => Koleksi::all()->count(),  
            "active" => 'Admin',
            "title" => 'Dashboard',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Images  $images
     * @return \Illuminate\Http\Response
     */
    public function show(Images $images)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Images  $images
     * @return \Illuminate\Http\Response
     */
    public function edit(Images $images)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Images  $images
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Images $images)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Images  $images
     * @return \Illuminate\Http\Response
     */
    public function destroy(Images $images)
    {
        //
    }
}
