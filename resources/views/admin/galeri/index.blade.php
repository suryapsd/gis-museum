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
					<h5 class="mb-0">List {{$title}} {{ $data_museum->nama }}</h5>
					<a href="javascript:void(0)" id="addNewData" class="btn btn-primary">
					    <span class="tf-icons bx bx-plus"></span>&nbsp; Tambah Data 
                    </a>
				</div>
				<div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table id="{{$table_id}}" class="table" style="width: 100%;">
                        <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Galeri</th>
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
            <form action="javascript:void(0)" id="modalForm" name="modalForm" method="POST"  class="form-horizontal">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="data_id" id="data_id">
                    <input type="hidden" name="museum_id" id="museum_id" value="{{ $data_museum->id }}">
                    <div class="row">
                        <div class="col mb-3">
                          <label for="nameBackdrop" class="form-label">Nama Galeri <span style="color: red">*</span></label>
                          <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama museum" value="" maxlength="50" required="">
                          <span class="invalid-feedback" id="nama_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                          <label for="nameBackdrop" class="form-label">Deskripsi <span style="color: red">*</span></label>
                          <textarea rows="5" id="desc" name="desc" class="form-control" value=""  required="" placeholder="Masukkan deskripsi galeri" aria-describedby="basic-icon-default-message2"></textarea>
                          <span class="invalid-feedback" id="desc_error"></span>
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
                url: '{{url("museum/ajaxGaleri")}}/' + {{ $data_museum->id }},
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
                {
                    data: 'nama',
                    name: 'nama',
                    orderable: true,
                    searchable: true,
                    class: 'text-left'
                },
                {
                    data: 'description',
                    name: 'description',
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

    $('#addNewData').click(function () {
            $('#saveBtn').val("create-galeri");
            $('#data_id').val('');
            $('#modalForm').trigger("reset");
            $('#modelHeading').html("Tambah Data Galeri Museum");
            $('#ajaxModel').modal('show');
    });
    
    $('body').on('click', '.editData', function () {
        var data_id = $(this).data('id');
        $.get("{{url('/admin/museum')}}/" + {{ $data_museum->id }} + "/galeri/" + data_id +'/edit', function (data) {
            $('#modelHeading').html("Edit Data Galeri Museum");
            $('#saveBtn').val("edit-galeri");
            $('#ajaxModel').modal('show');
            $('#data_id').val(data.id);
            $('#nama').val(data.nama);
            $('#desc').val(data.desc);
        })
    });
    
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');

        // Remove the error handling for the "nama" and "Nama" fields
        $('#nama, #desc').removeClass('is-invalid');
        $('#nama-error, #desc-error').remove();

        $.ajax({
            data: $('#modalForm').serialize(),
            url:"{{ url('/admin/museum/') }}/" + {{ $data_museum->id }} + "/galeri",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#modalForm').trigger("reset");
                $('#saveBtn').html('Simpan');
                $('#ajaxModel').modal('hide');
                if(data.success == 1){
                    Swal.fire('Sukses', data.msg, 'success');
                }else{
                    Swal.fire('Gagal', data.msg, 'error');
                }
                table.draw();
            },
            error: function (data) {
                console.log('nama:', data.nama);
                console.log('Error:', data);
                $('#saveBtn').html('Save Changes');

                // Error handling for specific input fields
                if (data.responseJSON.errors) {
                    var errors = data.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        $("#" + key).addClass("is-invalid");
                        $("#" + key + "_error").text(value[0]);
                    });
                }
            }
        });
    });

    function removeErrors() {
        $(".form-control").removeClass("is-invalid");
        $(".invalid-feedback").text("");
    }

    // Function to reset form and remove errors when modal is closed
    $("#ajaxModel").on("hidden.bs.modal", function () {
        $('#modalForm').trigger("reset");
        removeErrors();
    });

    function deleteData(id){
        Swal.fire({
            icon:'warning',
            text: 'Hapus Data Galeri?',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url:"{{ url('/admin/museum/') }}/" + {{ $data_museum->id }} + "/galeri/" + id,
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