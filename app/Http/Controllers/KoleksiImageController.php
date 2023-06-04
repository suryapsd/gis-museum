<?php

namespace App\Http\Controllers;

use App\Models\KoleksiImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class KoleksiImageController extends Controller
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
    public function store(Request $request, $koleksi_id)
    {
        $this->validate($request, [
            'image_name[]' => 'image|mimes:png,jpg,jpeg',
        ]);

        if ($request->hasFile('image_name')) {
            foreach ($request->file('image_name') as $imagefile) {
                $image = new KoleksiImage;
                //$path = $imagefile->store('post-image');
                $uploadFile = time() . '_' . $imagefile->getClientOriginalName();
                $imagefile->move('uploads/imgCover/', $uploadFile);
                $image->koleksi_id = $koleksi_id;
                $image->path = $uploadFile;
                $image->save();
            }
            return redirect()->back()->with('success', 'Foto berhasil ditambahkan');
        }else {
            return redirect()->back()->with('error', 'Foto gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KoleksiImage  $koleksiImage
     * @return \Illuminate\Http\Response
     */
    public function show(KoleksiImage $koleksiImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KoleksiImage  $koleksiImage
     * @return \Illuminate\Http\Response
     */
    public function edit(KoleksiImage $koleksiImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KoleksiImage  $koleksiImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KoleksiImage $koleksiImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KoleksiImage  $koleksiImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(KoleksiImage $koleksiImage)
    {
        //
    }
}
