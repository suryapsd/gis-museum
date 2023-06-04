<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;
use App\Models\Museum;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;

class PengurusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private  $active = 'Master';
    private  $title = 'Pengurus';
    
    public function index($museum_id)
    {
        return view('admin.pengurus.index', [
            "active" => $this->active,
            "title" => $this->title,
            "data_museum" => Museum::find($museum_id),
            "table_id" => "museum_id"
        ]);
    }

    public function getData(Request $request, $id)
    {
        $data = Pengurus::where('museum_id', $id)->get();

        $datatables = DataTables::of($data);
		return $datatables
        ->addIndexColumn()
        ->addColumn('status_pengurus', function($data){
            $statusBadge = "";
            if ($data->is_aktif == '1') {
                $statusBadge = '<span class="badge rounded-pill bg-label-success">Aktif</span>';
            } elseif ($data->is_aktif == '2') {
                $statusBadge = '<span class="badge rounded-pill bg-label-secondary">Cuti</span>';
            } elseif ($data->is_aktif == '3') {
                $statusBadge = '<span class="badge rounded-pill bg-label-danger">Non-Aktif</span>';
            }
            return $statusBadge;
        })
        ->addColumn('action', function($data){
            $actionBtn = "
            <button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                <i class='bx bx-dots-vertical-rounded'></i>
            </button>
            <div class='dropdown-menu'>
                <a class='dropdown-item' href='/admin/museum/{$data->museum_id}/pengurus/{$data->id}/edit'><i class='bx bx-edit-alt me-1'></i> Edit</a>
                <a class='dropdown-item' href='javascript:void(0)' onclick='deleteData(\"{$data->id}\")' data-id='{$data->id}'><i class='bx bx-trash me-1'></i> Delete</a>
            </div>
            ";
            return $actionBtn;
        })
        ->rawColumns(['action', 'status_pengurus'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('admin.pengurus.add',[
            "data_museum" => Museum::find($id),
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
    public function store(Request $request, $museum_id)
    {
        // Lakukan validasi data
        $this->validate($request, [
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'nama' => 'required',
            'jabatan' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'waktu_mulai' => 'required',
            'is_aktif' => 'required'
        ]);
        
        $data = new Pengurus();
        // Memasukkan nilai untuk masing-masing field pada tabel space berdasarkan inputan dari
        // form create 
        $data->museum_id = $museum_id;
        $data->nama_pengurus = $request->nama;
        $data->jabatan = $request->jabatan;
        $data->alamat_pengurus = $request->alamat;
        $data->telepon_pengurus = $request->telepon;
        $data->waktu_mulai = $request->waktu_mulai;
        $data->waktu_akhir = $request->waktu_akhir;
        $data->is_aktif = $request->is_aktif;

        // melakukan pengecekan ketika ada file gambar yang akan di input
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadFile = time() . '_' . $file->getClientOriginalName();
            $file->move('uploads/imgCover/', $uploadFile);
            $data->image = $uploadFile;
        }else{
            $data->image = 'store_profile.jpg';
        }

        $data->save();

        

        // redirect ke halaman index space
        if ($data) {
            return redirect('/admin/museum/'.$museum_id.'/pengurus/')->with('success', 'Data berhasil disimpan');
        } else {
            return redirect('/admin/museum/'.$museum_id.'/pengurus')->with('error', 'Data gagal disimpan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function show(Pengurus $map)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function edit($museum_id, $id)
    {
        return view('admin.pengurus.edit', [
            "data_museum" => Museum::find($museum_id),
            "data" => Pengurus::find($id),
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
    public function update(Request $request, $museum_id, $id)
    {
        // Lakukan validasi data
        $this->validate($request, [
            'image' => 'image|mimes:png,jpg,jpeg',
            'nama' => 'required',
            'jabatan' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'waktu_mulai' => 'required',
            'is_aktif' => 'required'
        ]);

        $museum_id = $request->museum_id;
        //dd($id);
        // Jika data yang akan diganti ada pada tabel space
        // cek terlebih dahulu apakah akan mengganti gambar atau tidak
        // jika gambar diganti hapus terlebuh dahulu gambar lama
        $data = Pengurus::findOrFail($id);
        if ($request->hasFile('image')) {
            
            if (File::exists("uploads/imgCover/" . $data->image)) {
                File::delete("uploads/imgCover/" . $data->image);
            }
            
            $file = $request->file("image");
            //$uploadFile = StoreImage::replace($space->image,$file->getRealPath(),$file->getClientOriginalName());
            $uploadFile = time() . '_' . $file->getClientOriginalName();
            $file->move('uploads/imgCover/', $uploadFile);
            $data->image = $uploadFile;
        }

        // Lakukan Proses update data ke tabel space
        $data->nama_pengurus = $request->nama;
        $data->alamat_pengurus = $request->alamat;
        $data->telepon_pengurus = $request->telepon;
        $data->waktu_mulai = $request->waktu_mulai;
        $data->waktu_akhir = $request->waktu_akhir;
        $data->is_aktif = $request->is_aktif;

        $data->save();
       
        // redirect ke halaman index space
        if ($data) {
            return redirect('/admin/museum/'.$museum_id.'/pengurus/')->with('success', 'Data berhasil diupdate');
        } else {
            return redirect('/admin/museum/'.$museum_id.'/pengurus/')->with('error', 'Data gagal diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function destroy($museum_id, $id)
    {
        $data = Pengurus::find($id); 
        $data->deleted_at = date('Y-m-d H:i:s');
        //$data->updated_by = auth()->user()->id;
        if($data->save()){
            $response = array('success'=>1,'msg'=>'Data berhasil dihapus');
        }else{
            $response = array('success'=>2,'msg'=>'Data gagal dihapus');
        }
        return $response;
    }
}
