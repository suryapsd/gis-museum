<?php

namespace App\Http\Controllers;

use App\Models\Koleksi;
use App\Models\Galeri;
use App\Models\KoleksiImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;

class KoleksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private  $active = 'Master';
    private  $title = 'Koleksi';

    public function index($galeri_id)
    {
        return view('admin.koleksi.index', [
            "active" => $this->active,
            "title" => $this->title,
            "data_galeri" => Galeri::find($galeri_id),
            "table_id" => "galeri_id"
        ]);
    }

    public function getData(Request $request, $id)
    {
        $data = Koleksi::where('galeri_id', $id)->get();

        $datatables = DataTables::of($data);
		return $datatables
        ->addIndexColumn()
        ->addColumn('image_koleksi', function($data){
            $imagePath = "
            <div id='carouselExample{$data->id}' class='carousel slide' data-bs-ride='carousel'>
                <div class='carousel-inner'>";

            foreach ($data->koleksi_images as $index => $image) {
                $activeClass = $index === 0 ? 'active' : '';
                $imagePath .= "
                    <div class='carousel-item {$activeClass}'>
                        <img class='d-block w-100' src='/uploads/imgCover/{$image->path}' height='50' alt='Image " . ($index + 1) . "'>
                    </div>";
            }

            $imagePath .= "
                </div>
                <a class='carousel-control-prev' href='#carouselExample{$data->id}' role='button' data-bs-slide='prev'>
                    <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                    <span class='visually-hidden'>Previous</span>
                </a>
                <a class='carousel-control-next' href='#carouselExample{$data->id}' role='button' data-bs-slide='next'>
                    <span class='carousel-control-next-icon' aria-hidden='true'></span>
                    <span class='visually-hidden'>Next</span>
                </a>
            </div>";
            return $imagePath;
        })
        ->addColumn('formatted_date', function ($data) {
            // Modify the date format using Carbon
            return Carbon::parse($data->tahun)->formatLocalized('%e %B %Y');
        })
        ->addColumn('action', function($data){
            $actionBtn = "
                <a href='javascript:void(0)' onclick='addData(\"{$data->id}\")' data-id='{$data->id}' class='btn btn-icon btn-warning' title='tambah foto koleksi'><span class='tf-icons bx bx-image-add'></span></a>
                <a href='/admin/galeri/$data->galeri_id/koleksi/$data->id/edit' class='btn btn-icon btn-primary' title='edit data'><span class='tf-icons bx bx-edit-alt'></span></a>
                <a href='javascript:void(0)' onclick='deleteData(\"{$data->id}\")' data-id='{$data->id}' class='btn btn-icon btn-danger' title='hapus data'><span class='tf-icons bx bx-trash'></span></a>
            ";
            return $actionBtn;
        })
        ->addColumn('description', function($data){
            $desc = Str::words($data->desc, 4);
            return $desc;
        })
        ->rawColumns(['image_koleksi', 'formatted_date', 'action', 'description'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($galeri_id)
    {
        return view('admin.koleksi.add',[
            "data_galeri" => Galeri::find($galeri_id),
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
    public function store(Request $request, $galeri_id)
    {
        // Lakukan validasi data
        $this->validate($request, [
            'image_name[]' => 'image|mimes:png,jpg,jpeg',
            'image_name' => 'required',
            'nama' => 'required',
            'artist' => 'required',
            'tahun' => 'required',
            'desc' => 'required'
        ]);

        // melakukan pengecekan ketika ada file gambar yang akan di input
        $data = new Koleksi();
        // Memasukkan nilai untuk masing-masing field pada tabel space berdasarkan inputan dari
        // form create 
        $data->galeri_id = $galeri_id;
        $data->nama = $request->nama;
        $data->artist = $request->artist;
        $data->tahun = $request->tahun;
        $data->desc = $request->desc;
        // proses simpan data
        $data->save();

        foreach ($request->file('image_name') as $imagefile) {
            $image = new KoleksiImage;
            //$path = $imagefile->store('post-image');
            $uploadFile = time() . '_' . $imagefile->getClientOriginalName();
            $imagefile->move('uploads/imgCover/', $uploadFile);
            $image->koleksi_id = $data->id;
            $image->path = $uploadFile;
            $image->save();
        }

        // redirect ke halaman index space
        if ($data) {
            return redirect('/admin/galeri/'.$galeri_id.'/koleksi/')->with('success', 'Data berhasil disimpan');
        } else {
            return redirect('/admin/galeri/'.$galeri_id.'/koleksi/')->with('error', 'Data gagal disimpan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Koleksi  $koleksi
     * @return \Illuminate\Http\Response
     */
    public function show(Koleksi $koleksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Koleksi  $koleksi
     * @return \Illuminate\Http\Response
     */
    public function edit($galeri_id, $id)
    {
        return view('admin.koleksi.edit', [
            "data" => Koleksi::find($id),
            "data_galeri" => Galeri::find($galeri_id),
            "title" => $this->title,
            "active" => $this->active,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Koleksi  $koleksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $galeri_id, $id)
    {
        // Lakukan validasi data
        $this->validate($request, [
            'image_name[]' => 'image|mimes:png,jpg,jpeg',
            'nama' => 'required',
            'artist' => 'required',
            'tahun' => 'required',
            'desc' => 'required'
        ]);

        // melakukan pengecekan ketika ada file gambar yang akan di input
        $data = Koleksi::findOrFail($id);
        $data->nama = $request->nama;
        $data->artist = $request->artist;
        $data->tahun = $request->tahun;
        $data->desc = $request->desc;
        // proses simpan data
        $data->save();

        if ($request->hasFile('image_name')) {
            foreach ($request->file('image_name') as $imagefile) {
                $image = new KoleksiImage;
                //$path = $imagefile->store('post-image');
                $uploadFile = time() . '_' . $imagefile->getClientOriginalName();
                $imagefile->move('uploads/imgCover/', $uploadFile);
                $image->koleksi_id = $data->id;
                $image->path = $uploadFile;
                $image->save();
            }
        }

        // redirect ke halaman index space
        if ($data) {
            return redirect('/admin/galeri/'.$galeri_id.'/koleksi/')->with('success', 'Data berhasil disimpan');
        } else {
            return redirect('/admin/galeri/'.$galeri_id.'/koleksi/')->with('error', 'Data gagal disimpan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Koleksi  $koleksi
     * @return \Illuminate\Http\Response
     */
    public function destroy($galeri_id, $id)
    {
        $data = Koleksi::find($id); 
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
