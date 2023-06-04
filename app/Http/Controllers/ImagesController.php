<?php

namespace App\Http\Controllers;

use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, $museum_id)
    {
        $this->validate($request, [
            'image_name[]' => 'image|mimes:png,jpg,jpeg',
        ]);

        if ($request->hasFile('image_name')) {
            foreach ($request->file('image_name') as $imagefile) {
                $image = new Images;
                //$path = $imagefile->store('post-image');
                $uploadFile = time() . '_' . $imagefile->getClientOriginalName();
                $imagefile->move('uploads/imgCover/', $uploadFile);
                $image->museum_id = $museum_id;
                $image->path = $uploadFile;
                $image->save();
            }
            return redirect('/admin/museum/')->with('success', 'Foto berhasil ditambahkan');
        }else {
            return redirect('/admin/museum/')->with('error', 'Foto gagal ditambahkan');
        }
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
