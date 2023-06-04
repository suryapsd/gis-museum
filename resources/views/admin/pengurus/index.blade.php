@extends('admin.layouts_dashboard.app') @section('content')
<div class="container-xxl flex-grow-1 container-p-y">
	{{-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{$active}} /</span> {{$title}}</h4> --}}
    <a href="/admin/museum" class="btn btn-outline-primary mb-3">
        <span class="tf-icons bx bx-left-arrow-alt"></span>&nbsp; Kembali
    </a>
	<div class="row">
		<!-- Basic Layout -->
		<div class="col-xxl">
			<div class="card mb-4">
				<div class="card-header d-flex align-items-center justify-content-between">
					<h5 class="mb-0">List {{$title}} {{$data_museum->nama}}</h5>
					<a href="/admin/museum/{{$data_museum->id}}/pengurus/create" class="btn btn-primary">
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
                            <th>Jabatan</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Status</th>
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
            url: '{{url("museum/ajaxPengurus")}}/' + {{ $data_museum->id }},
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
            {   data: 'image', 
                name: 'image',
                render: function( data, type, full, meta ) {
                    return "<img src=\"/uploads/imgCover/" + data + "\" height=\"50\"/>";
                },
                title: "Image",
                orderable: false,
                searchable: false,
                class: 'text-center'
            },
            {
                data: 'nama_pengurus',
                name: 'nama_pengurus',
                orderable: true,
                searchable: true,
                class: 'text-left'
            },
            {
                data: 'jabatan',
                name: 'jabatan',
                orderable: false,
                searchable: true,
                class: 'text-center'
            },
            {
                data: 'telepon_pengurus',
                name: 'telepon_pengurus',
                orderable: true,
                searchable: true,
                class: 'text-center'
            },
            {
                data: 'alamat_pengurus',
                name: 'alamat_pengurus',
                orderable: true,
                searchable: true,
                class: 'text-center'
            },
            {
                data: 'status_pengurus',
                name: 'status_pengurus',
                orderable: true,
                searchable: true,
                class: 'text-center'
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

function deleteData(id){
    CustomSwal.fire({
        icon:'warning',
        text: 'Hapus Data Pengurus Museum?',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({
                url:"{{ url('/admin/museum/') }}/" + {{ $data_museum->id }} + "/pengurus/" + id,
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