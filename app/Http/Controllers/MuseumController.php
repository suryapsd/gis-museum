<?php

namespace App\Http\Controllers;

use App\Models\Museum;
use App\Models\Images;
use App\Models\JenisMuseum;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;

class MuseumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    private  $active = 'Master';
    private  $title = 'Museum';
    
    public function index()
    {
        return view('admin.museum.index', [
            "active" => $this->active,
            "title" => $this->title,
            // "posts" => Post::all()
            "table_id" => "museum_id"
        ]);
    }

    public function getData(Request $request)
    {
        
        $data = Museum::all();

        $datatables = DataTables::of($data);
		return $datatables
        ->addIndexColumn()
        ->editColumn('jenis_museum', function($row) {
            return $row->jenis_museum->jenis;
        })
        ->addColumn('action', function($data){
            $actionBtn = "
                <a href='javascript:void(0)' onclick='addData(\"{$data->id}\")' data-id='{$data->id}' class='btn btn-icon btn-secondary editData' title='tambah gambar'><span class='tf-icons bx bx-image-add'></span></a>
                <a href='/admin/museum/$data->id/galeri' class='btn btn-icon btn-success editData' title='galeri museum'><span class='tf-icons bx bx-category-alt'></span></a>
                <a href='/admin/museum/$data->id/pengurus' class='btn btn-icon btn-warning editData' title='pengurus museum'><span class='tf-icons bx bx-user'></span></a>
                <a href='/admin/museum/$data->id/edit' class='btn btn-icon btn-primary editData' title='edit data'><span class='tf-icons bx bx-edit-alt'></span></a>
                <a href='javascript:void(0)' onclick='deleteData(\"{$data->id}\")' data-id='{$data->id}' class='btn btn-icon btn-danger' title='hapus data'><span class='tf-icons bx bx-trash'></span></a>
            ";
            return $actionBtn;
        })
        ->rawColumns(['jenis_museum','action'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.museum.add',[
            "jenis" => JenisMuseum::all(),
            "active" => $this->active,
            "title" => $this->title,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Lakukan validasi data
        $this->validate($request, [
            'image_name[]' => 'image|mimes:png,jpg,jpeg',
            'image_name' => 'required',
            'name' => 'required',
            'jenis' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'desc' => 'required',
            'lat' => 'required',
            'long' => 'required'
        ]);

        // melakukan pengecekan ketika ada file gambar yang akan di input
        $data = new Museum();
        // Memasukkan nilai untuk masing-masing field pada tabel space berdasarkan inputan dari
        // form create 
        $data->nama = $request->input('name');
        $data->jenis_id = $request->input('jenis');
        $data->alamat = $request->input('alamat');
        $data->telepon = $request->input('telepon');
        $data->desc = $request->input('desc');
        $data->lat = $request->input('lat');
        $data->long = $request->input('long');
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $uploadFile = time() . '_' . $file->getClientOriginalName();
            $file->move('uploads/icon/', $uploadFile);
            $data->icon = $uploadFile;
        }else{
            $data->icon = 'museum.png';
        }
        // proses simpan data
        $data->save();

        foreach ($request->file('image_name') as $imagefile) {
            $image = new Images;
            //$path = $imagefile->store('post-image');
            $uploadFile = time() . '_' . $imagefile->getClientOriginalName();
            $imagefile->move('uploads/imgCover/', $uploadFile);
            $image->museum_id = $data->id;
            $image->path = $uploadFile;
            $image->save();
        }

        // redirect ke halaman index space
        if ($data) {
            return redirect('/admin/museum')->with('success', 'Data berhasil disimpan');
        } else {
            return redirect('/admin/museum')->with('error', 'Data gagal disimpan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function show(Map $map)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.museum.edit', [
            "data" => Museum::find($id),
            "jenis" => JenisMuseum::all(),
            "title" => $this->title,
            "active" => $this->active,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Lakukan validasi data
        $this->validate($request, [
            'image_name[]' => 'image|mimes:png,jpg,jpeg',
            'name' => 'required',
            'jenis' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'desc' => 'required',
            'lat' => 'required',
            'long' => 'required'
        ]);

        $data = Museum::findOrFail($id);
        $data->nama = $request->input('name');
        $data->jenis_id = $request->input('jenis');
        $data->alamat = $request->input('alamat');
        $data->telepon = $request->input('telepon');
        $data->desc = $request->input('desc');
        $data->lat = $request->input('lat');
        $data->long = $request->input('long');
        if ($request->hasFile('icon')) {
            // if (File::exists("uploads/icon/" . $data->icon)) {
            //     File::delete("uploads/icon/" . $data->icon);
            // }
            $file = $request->file("icon");
            //$uploadFile = StoreImage::replace($space->image,$file->getRealPath(),$file->getClientOriginalName());
            $uploadFile = time() . '_' . $file->getClientOriginalName();
            $file->move('uploads/icon/', $uploadFile);
            $data->icon = $uploadFile;
        }

        $data->update();

        if ($request->hasFile('image_name')) {
            foreach ($request->file('image_name') as $imagefile) {
                $image = new Images;
                //$path = $imagefile->store('post-image');
                $uploadFile = time() . '_' . $imagefile->getClientOriginalName();
                $imagefile->move('uploads/imgCover/', $uploadFile);
                $image->museum_id = $data->id;
                $image->path = $uploadFile;
                $image->save();
            }
        }

        /// redirect ke halaman index space
        if ($data) {
            return redirect('/admin/museum')->with('success', 'Data berhasil disimpan');
        } else {
            return redirect('/admin/museum')->with('error', 'Data gagal disimpan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Museum::find($id); 
        $data->deleted_at = date('Y-m-d H:i:s');
        //$data->updated_by = auth()->user()->id;
        if($data->save()){
            $response = array('success'=>1,'msg'=>'Data berhasil dihapus');
        }else{
            $response = array('error'=>2,'msg'=>'Data gagal dihapus');
        }
        return $response;
    }
}
