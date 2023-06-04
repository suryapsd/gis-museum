<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\Museum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use DB;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private  $active = 'Master';
    private  $title = 'Galeri';

    public function index($museum_id)
    {
        return view('admin.galeri.index', [
            "active" => $this->active,
            "title" => $this->title,
            "data_museum" => Museum::find($museum_id),
            "table_id" => "museum_id"
        ]);
    }

    public function getData(Request $request, $id)
    {
        $data = Galeri::where('museum_id', $id)->get();

        $datatables = DataTables::of($data);
		return $datatables
        ->addIndexColumn()
        ->addColumn('action', function($data){
            $actionBtn = "
            <button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                <i class='bx bx-dots-vertical-rounded'></i>
            </button>
            <div class='dropdown-menu'>
                <a class='dropdown-item' href='/admin/galeri/$data->id/koleksi/' data-id='{$data->id}'><i class='bx bx-image-add me-1'></i> Koleksi Galeri</a>
                <a class='dropdown-item editData' href='javascript:void(0)' data-id='{$data->id}'><i class='bx bx-edit-alt me-1'></i> Edit</a>
                <a class='dropdown-item' href='javascript:void(0)' onclick='deleteData(\"{$data->id}\")' data-id='{$data->id}'><i class='bx bx-trash me-1'></i> Delete</a>
            </div>
            ";
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
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
        // Validate the input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:50',
            'desc' => 'required',
        ]);

        // If validation fails, return the error response
        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'msg' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = Galeri::updateOrCreate(
            ['id' => $request->data_id],
            ['museum_id' => $request->museum_id, 'nama' => $request->nama, 'desc' => $request->desc]
        );        
   
        if($data){
            $response = array('success'=>1,'msg'=>'Data berhasl disimpan');
        }else{
            $response = array('success'=>2,'msg'=>'Data gagal disimpan');
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Galeri  $galeri
     * @return \Illuminate\Http\Response
     */
    public function show(Galeri $galeri)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Galeri  $galeri
     * @return \Illuminate\Http\Response
     */
    public function edit($museum_id, $id)
    {
        $data = Galeri::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Galeri  $galeri
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Galeri $galeri)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Galeri  $galeri
     * @return \Illuminate\Http\Response
     */
    public function destroy($museum_id, $id)
    {
        $data = Galeri::find($id); 
        $data->deleted_at = date('Y-m-d H:i:s');
        //$data->updated_by = auth()->user()->id;
        if($data->save()){
            $response = array('success'=>1,'msg'=>'Berhasil hapus data');
        }else{
            $response = array('success'=>2,'msg'=>'Gagal hapus data');
        }
        return $response;
    }
}
