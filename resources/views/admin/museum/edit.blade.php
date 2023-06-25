@extends('admin.layouts_dashboard.app') 
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
	{{-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{$active}}/</span> {{$title}}</h4> --}}
	<!-- Basic Layout & Basic with Icons -->
	<div class="row">
		<!-- Basic Layout -->
		<div class="col-xxl">
			<div class="card mb-4">
				<div class="card-header d-flex align-items-center justify-content-between">
					<h5 class="mb-0">Edit Data {{$title}}</h5>
					<small class="text-muted float-end">------</small>
				</div>
				<hr class="my-0"/>
				<div class="card-body">
					<form action="/admin/museum/{{$data->id}}" method="post" enctype="multipart/form-data">
						@method('PUT')
						@csrf
						<div class="row mb-3">
							<div class="col-md-6">
								<label class="form-label" for="basic-default-name">Foto Museum <span style="color: red">*</span></label>
								<div class="input-group">
									<input type='file' class="form-control @error('image_name') is-invalid @enderror" name="image_name[]" id="image_name" multiple accept=".png, .jpg, .jpeg" />
									<label class="input-group-text" for="image_name">Choose images</label>
									@error('image_name')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<label class="form-label" for="basic-default-name">Marker Museum</label>
								<div class="input-group">
									<input type='file' class="form-control @error('icon') is-invalid @enderror" name="icon" id="icon" accept=".png" />
									<label class="input-group-text" for="icon">Choose marker</label>
									@error('icon')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-md-6">
								<label class="form-label" for="basic-default-name">Nama Museum <span style="color: red">*</span></label>
								<div class="form-group">
									<input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{$data->nama}}" placeholder="Masukkan nama museum"/>
									@error('name')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div>
									<label for="exampleFormControlSelect1" class="form-label">Jenis Museum <span style="color: red">*</span></label>
									<select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis" aria-label="Default select example">
									<option>Pilih jenis museum</option>
										@foreach($jenis as $jenism)
										<option value="{{ $jenism->id }}"
										@if($data->jenis_id == $jenism->id)
											selected
										@endif
											>{{ $jenism->jenis }}</option>
										@endforeach
									</select>
									@error('jenis')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-md-6">
								<label class="form-label" for="basic-default-name">Telepon <span style="color: red">*</span></label>
								<div class="form-group">
									<input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{$data->telepon}}" placeholder="089xxxxxxxxx"/>
									@error('telepon')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<label class="form-label" for="basic-default-name">Alamat <span style="color: red">*</span></label>
								<div class="form-group">
									<input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{$data->alamat}}" placeholder="Masukkan alamat museum"/>
									@error('alamat')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<label class="form-label" for="basic-default-message">Deskripsi <span style="color: red">*</span></label>
							<div class="form-group">
								<textarea id="desc" name="desc" class="form-control @error('desc') is-invalid @enderror" placeholder="Masukkan deskripsi museum" aria-describedby="basic-icon-default-message2">{{$data->desc}}</textarea>
								@error('desc')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-md-6 mb-3">
								<label class="form-label" for="basic-default-name">Latitude <span style="color: red">*</span></label>
								<div class="form-group">
									<input type="text" class="form-control" id="lat" name="lat" value="{{$data->lat}}" placeholder="Latitude" readonly/>
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label" for="basic-default-name">Longtitude <span style="color: red">*</span></label>
								<div class="form-group">
									<input type="text" class="form-control" id="long" name="long" value="{{$data->long}}" placeholder="Longtitude" readonly/>
								</div>
							</div>
						</div>
						<div id="map" style="width: 100%; height: 400px;"></div>
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
<script>
    document.addEventListener('DOMContentLoaded', function (e) {
        (function () {
            const deactivateAcc = document.querySelector('#formAccountDeactivation');
            // Update/reset user image of account page
            let accountUserImage = document.getElementById('uploadedAvatar');
            const fileInput = document.querySelector('.account-file-input'),
            resetFileInput = document.querySelector('.account-image-reset');
            if (accountUserImage) {
            const resetImage = accountUserImage.src;
            fileInput.onchange = () => {
                if (fileInput.files[0]) {
                accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
                }
            };
            resetFileInput.onclick = () => {
                fileInput.value = '';
                accountUserImage.src = resetImage;
            };
            }
        })();
    });
    var peta = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });

    var map = L.map('map', {
        center: [-8.537304773847266, 115.12583771558118],
        zoom: 10,
        layers: [peta]
    });

	var curLocation = [{{$data->lat}} , {{$data->long}} ];
	map.attributionControl.setPrefix(false);

	var micon = L.icon({
	  iconUrl: "/admin/assets/img/avatars/museum.png",
	  iconSize: [34, 34], // size of the icon
	  popupAnchor: [0, -30], // point from which the popup should open relative to the iconAnchor
	});

	var marker = new L.marker(curLocation, {
        draggable: 'true',
		icon: micon,
    });

    map.addLayer(marker);

    marker.on('dragend', function(event) {
        var location = marker.getLatLng();
        marker.setLatLng(location, {
            draggable: 'true',
        }).bindPopup(location).update();
        $('#lat').val(location.lat).keyup()
		$('#long').val(location.lng).keyup()
    });

    var latitude = document.querySelector("[name=lat]");
	var longtitude = document.querySelector("[name=long]");
    map.on("click", function(e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;
        if (!marker) {
            marker = L.marker(e.latlng).addTo(map);
        } else {
            marker.setLatLng(e.latlng);
        }
		latitude.value = lat;
        longtitude.value = lng;
    });
</script>
@endsection