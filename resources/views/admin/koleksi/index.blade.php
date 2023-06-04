@extends('admin.layouts_dashboard.app') @section('content')
<div class="container-xxl flex-grow-1 container-p-y">
	{{-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{$active}} /</span> {{$title}}</h4> --}}
    <a href="/admin/museum/{{$data_galeri->museum_id}}/galeri" class="btn btn-outline-primary mb-3">
        <span class="tf-icons bx bx-left-arrow-alt"></span>&nbsp; Kembali
    </a>
    <script>
        @if (\Session::has('success'))
          Swal.fire(
            'Success',
            '{!! \Session::get('success') !!}',
            'success'
          )
        @elseif(\Session::has('error'))
          Swal.fire(
            'Opps!',
            '{!! \Session::get('error') !!}',
            'error'
          )
        @endif 
    </script>
	<div class="row">
		<!-- Basic Layout -->
		<div class="col-xxl">
			<div class="card mb-4">
				<div class="card-header d-flex align-items-center justify-content-between">
					<h5 class="mb-0">List {{$title}} Galeri {{$data_galeri->nama}}</h5>
					<a href="/admin/galeri/{{$data_galeri->id}}/koleksi/create" class="btn btn-primary">
					    <span class="tf-icons bx bx-plus"></span>&nbsp; Tambah Data 
                    </a>
				</div>
				<div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table id="{{$table_id}}" class="table" style="width: 100%;">
                        <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Artist</th>
                            <th>Tahun Pembuatan</th>
                            <th>Deskripsi</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        </tbody>
                        </table>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- / Content -->
<!-- Modal Layout -->
<div class="modal fade" id="ajaxModel" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading">Modal title</h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
            </div>
            <form action="/admin/koleksi/" id="modalForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="text" hidden name="museum_id" id="museum_id" value="">
                    <div class="row">
                        <label class="form-label" for="basic-default-name">Foto Museum</label>
							<div class="input-group">
                                <input type='file' class="form-control @error('image_name') is-invalid @enderror" name="image_name[]" id="image_name" multiple accept=".png, .jpg, .jpeg" />
                                <label class="input-group-text" for="image_name">Choose images</label>
                                @error('image_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                      </button>
                      <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
@push('script')
<script type="text/javascript">
var table;
$(document).ready(function() {
    table = $('#{{$table_id}}').DataTable({
        
        "language": {
            "lengthMenu": "_MENU_",
            /* 'loadingRecords': '&nbsp;',
            'processing': '<img src="{{asset('assets/img/loader-sm.gif')}}"/>' */
        },
        processing:true,
        autoWidth: true,
        ordering: true,
        serverSide: true,
        ajax: {
            url: '{{url("museum/ajaxKoleksi")}}/' + {{ $data_galeri->id }},
            type:"POST",
            data: function(params) {
                params._token = "{{ csrf_token() }}";
            }
        },
        
        language: {
            search: "",
            searchPlaceholder: "Type in to Search",
            lengthMenu: "<div class='d-flex justify-content-start form-control-select'> _MENU_ </div>",
            // info: "_START_ -_END_ of _TOTAL_",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_",
            infoEmpty: "No records found",
            infoFiltered: "( Total _MAX_  )",
            paginate: {
              "first": "First",
              "last": "Last",
              "next": "Next",
              "previous": "Prev"
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, class: 'text-left' },    
            {   data: 'image_koleksi', 
                name: 'image_koleksi',
                title: "Image",
                orderable: false,
                searchable: false,
                class: 'text-center'
            },
            {
                data: 'nama',
                name: 'nama',
                orderable: true,
                searchable: true,
                class: 'text-left'
            },
            {
                data: 'artist',
                name: 'artist',
                orderable: false,
                searchable: true,
                class: 'text-left'
            },
            {
                data: 'formatted_date',
                name: 'formatted_date',
                orderable: true,
                searchable: true,
                class: 'text-center'
            },
            {
                data: 'desc',
                name: 'desc',
                orderable: true,
                searchable: true,
                class: 'text-left'
            },
            {
                data: 'action',
                name: 'id',
                orderable: false,
                searchable: false,
                class: 'text-center'
            }
        ]
    });
    
    $("#{{$table_id}}").DataTable().processing(true);
    $('#{{$table_id}}_filter input').unbind();
    $('#{{$table_id}}_filter input').bind('keyup', function(e) {
        if(e.keyCode == 13) {
            table.search(this.value).draw();   
        }
    });
    $('.dataTables_filter').html('<div class="input-group flex-nowrap"><span class="input-group-text" id="addon-wrapping"><i class="bi bi-search"></i></span><input type="search" class="form-control form-control-sm" placeholder="Type in to Search" aria-label="Type in to Search" aria-describedby="addon-wrapping"></div>');
});

function addData(id){
        document.getElementById("modalForm").action += id + "/koleksi-images";
        document.getElementById("galeri_id").value = id;
        $('#saveBtn').val("create-koleksi");
        $('#data_id').val('');
        $('#modalForm').trigger("reset");
        $('#modelHeading').html("Tambah Foto Koleksi");
        $('#ajaxModel').modal('show');
    }

function deleteData(id){
    CustomSwal.fire({
        icon:'warning',
        text: 'Hapus Data Koleksi?',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({
                url:"{{ url('/admin/galeri/') }}/" + {{ $data_galeri->id }} + "/koleksi/" + id,
                data:{
                    _method:"DELETE",
                    _token:"{{csrf_token()}}"
                },
                type:"POST",
                dataType:"JSON",
                beforeSend:function(){
                    block("#{{$table_id}}");
                },
                success:function(data){
                    if(data.success == 1){
                        Swal.fire('Sukses', data.msg, 'success');
                    }else{
                        Swal.fire('Gagal', data.msg, 'error');
                    }
                    unblock("#{{$table_id}}");
                    RefreshTable('{{$table_id}}',0);
                },
                error:function(error){
                    Swal.fire('Gagal', 'terjadi kesalahan sistem', 'error');
                    console.log(error.XMLHttpRequest);
                    unblock("#{{$table_id}}");
                    RefreshTable('{{$table_id}}',0);
                }
            });
        }
    });
}
</script>
@endpush
@endsection