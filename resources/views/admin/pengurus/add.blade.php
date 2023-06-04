@extends('admin.layouts_dashboard.app') 
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
	{{-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{$active}}/</span> {{$title}}</h4> --}}
	<a href="/admin/museum/{{$data_museum->id}}/pengurus" class="btn btn-outline-primary mb-3">
        <span class="tf-icons bx bx-left-arrow-alt"></span>&nbsp; Kembali
    </a>
	<!-- Basic Layout & Basic with Icons -->
	<div class="row">
		<!-- Basic Layout -->
		<div class="col-xxl">
			<div class="card mb-4">
				<div class="card-header d-flex align-items-center justify-content-between">
					<h5 class="mb-0">Input Data {{$title}} {{$data_museum->nama}}</h5>
					<small class="text-muted float-end">------</small>
				</div>
				<hr class="my-0"/>
				<div class="card-body">
					<form action="/admin/museum/{{$data_museum->id}}/pengurus" method="post" enctype="multipart/form-data">
						 @csrf
						 <input type="hidden" name="museum_id" id="museum_id" value="{{$data_museum->id}}">
						 <div class="row mb-3">
							<label class="form-label" for="basic-default-name">Foto Museum</label>
							<div class="input-group">
                                <input type='file' class="form-control @error('image') is-invalid @enderror" name="image" id="image" multiple accept=".png, .jpg, .jpeg" />
                                <label class="input-group-text" for="image">Choose images</label>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
						</div>
						<div class="row mb-3">
							<div class="col-md-6">
								<label class="form-label" for="basic-default-name">Nama Pengurus</label>
								<div class="form-group">
									<input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Masukkan nama pengurus"/>
									@error('nama')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<label class="form-label" for="basic-default-name">Jabatan</label>
								<div class="form-group">
									<input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" placeholder="Masukkan jabatan pengurus"/>
									@error('jabatan')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-md-6">
								<label class="form-label" for="basic-default-name">Telepon</label>
								<div class="form-group">
									<input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" placeholder="089xxxxxxxxx"/>
									@error('telepon')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<label class="form-label" for="basic-default-name">Alamat</label>
								<div class="form-group">
									<input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" placeholder="Masukkan alamat pengurus"/>
									@error('alamat')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-md-4">
								<label class="form-label" for="basic-default-name">Waktu Mulai</label>
								<div class="form-group">
									<input type="date" class="form-control @error('waktu_mulai') is-invalid @enderror" id="waktu_mulai" name="waktu_mulai" placeholder="dd/mm/yyyy"/>
									@error('waktu_mulai')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-4">
								<label class="form-label" for="basic-default-name">Waktu Akhir</label>
								<div class="form-group">
									<input type="date" class="form-control @error('waktu_akhir') is-invalid @enderror" id="waktu_akhir" name="waktu_akhir" placeholder="dd/mm/yyyy"/>
									@error('waktu_akhir')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-4">
								<div>
									<label for="exampleFormControlSelect1" class="form-label">Status</label>
									<select class="form-select" id="is_aktif" name="is_aktif" aria-label="Default select example">
									<option selected>Pilih status pengurus</option>
									<option value="1">Aktif</option>
									</select>
								</div>
							</div>
						</div>
						<hr>
						<div class="row justify-content-end">
							<div class="col">
								<button type="submit" class="btn btn-primary">Save</button>
								<a href="/admin/museum" class="btn btn-outline-secondary">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- / Content -->
@endsection