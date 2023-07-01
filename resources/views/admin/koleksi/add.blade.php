@extends('admin.layouts_dashboard.app') 
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
	{{-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{$active}}/</span> {{$title}}</h4> --}}
	<a href="/admin/galeri/{{$data_galeri->id}}/koleksi" class="btn btn-outline-primary mb-3">
        <span class="tf-icons bx bx-left-arrow-alt"></span>&nbsp; Kembali
    </a>
	<!-- Basic Layout & Basic with Icons -->
	<div class="row">
		<!-- Basic Layout -->
		<div class="col-xxl">
			<div class="card mb-4">
				<div class="card-header d-flex align-items-center justify-content-between">
					<h5 class="mb-0">Input Data {{$title}} {{$data_galeri->nama}}</h5>
					<small class="text-muted float-end">------</small>
				</div>
				<hr class="my-0"/>
				<div class="card-body">
					<form action="/admin/galeri/{{$data_galeri->id}}/koleksi" method="post" enctype="multipart/form-data">
						 @csrf
						 <input type="hidden" name="galeri_id" id="galeri_id" value="{{$data_galeri->id}}">
						 <div class="row mb-3">
							<label class="form-label" for="basic-default-name">Foto Koleksi <span style="color: red">*</span></label>
							<div class="input-group">
                                <input type='file' class="form-control @error('image_name') is-invalid @enderror" name="image_name[]" id="image_name" multiple accept=".png, .jpg, .jpeg" />
                                <label class="input-group-text" for="image_name">Choose images</label>
                                @error('image_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
						</div>
						<div class="row mb-3">
							<label class="form-label" for="basic-default-name">Nama Koleksi/Karya <span style="color: red">*</span></label>
								<div class="form-group">
									<input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Masukkan nama koleksi/karya"/>
									@error('nama')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-md-6">
								<label class="form-label" for="basic-default-name">Nama Pembuat Karya/Seniman <span style="color: red">*</span></label>
								<div class="form-group">
									<input type="text" class="form-control @error('artist') is-invalid @enderror" id="artist" name="artist" placeholder="Masukkan nama artist/pembuat"/>
									@error('artist')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<label class="form-label" for="basic-default-name">Waktu Pembuatan  <span style="color: red">*</span></label>
								<div class="form-group">
									<input type="date" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" placeholder="dd/mm/yyyy"/>
									@error('tahun')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<label class="form-label" for="basic-default-message">Deskripsi <span style="color: red">*</span></label>
							<div class="form-group">
								<textarea rows="5" id="desc" name="desc" class="form-control @error('desc') is-invalid @enderror" placeholder="Masukkan deskripsi koleksi/karya" aria-describedby="basic-icon-default-message2"></textarea>
								@error('desc')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
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