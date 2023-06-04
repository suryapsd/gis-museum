@extends('admin.layouts_dashboard.app') 
@section('content') 
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
	<!-- Basic Layout & Basic with Icons -->
	<div class="col-lg-12 col-md-4 order-1">
		<div class="row">
		  <div class="col-lg-3 col-md-12 col-6 mb-4">
			<div class="card">
			  <div class="card-body">
				<div class="card-title d-flex align-items-start justify-content-between">
				  <div class="avatar flex-shrink-0">
					<img
					  src="{{ asset('admin/assets/img/icons/unicons/chart-success.png') }}"
					  alt="chart success"
					  class="rounded"
					/>
				  </div>
				</div>
				<span class="fw-semibold d-block mb-1">Jenis Museum</span>
				<h3 class="card-title mb-2">{{$jenis_count}}</h3>
			  </div>
			</div>
		  </div>
		  <div class="col-lg-3 col-md-12 col-6 mb-4">
			<div class="card">
			  <div class="card-body">
				<div class="card-title d-flex align-items-start justify-content-between">
				  <div class="avatar flex-shrink-0">
					<img
					  src="{{ asset('admin/assets/img/icons/unicons/wallet-info.png') }}"
					  alt="Credit Card"
					  class="rounded"
					/>
				  </div>
				</div>
				<span class="fw-semibold d-block mb-1">Museum</span>
				<h3 class="card-title text-nowrap mb-1">{{$spaces_count}}</h3>
			  </div>
			</div>
		  </div>
		  <div class="col-lg-3 col-md-12 col-6 mb-4">
			<div class="card">
			  <div class="card-body">
				<div class="card-title d-flex align-items-start justify-content-between">
				  <div class="avatar flex-shrink-0">
					<img src="{{ asset('admin/assets/img/icons/unicons/paypal.png') }}" alt="Credit Card" class="rounded" />
				  </div>
				</div>
				<span class="fw-semibold d-block mb-1">Galeri</span>
				<h3 class="card-title text-nowrap mb-2">{{$galeri_count}}</h3>
			  </div>
			</div>
		  </div>
		  <div class="col-lg-3 col-md-12 col-6 mb-4">
			<div class="card">
			  <div class="card-body">
				<div class="card-title d-flex align-items-start justify-content-between">
				  <div class="avatar flex-shrink-0">
					<img src="{{ asset('admin/assets/img/icons/unicons/cc-primary.png') }}" alt="Credit Card" class="rounded" />
				  </div>
				</div>
				<span class="fw-semibold d-block mb-1">Koleksi</span>
				<h3 class="card-title mb-2">{{$koleksi_count}}</h3>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	<div class="row">
		<!-- Basic Layout -->
		<div class="col-xxl">
			<div class="card mb-4">
				<div class="card-header d-flex align-items-center justify-content-between">
					<h5 class="mb-0">Map Museum</h5>
					<small class="text-muted float-end">Default label</small>
				</div>
				<hr class="my-0"/>
				<div class="card-body">
					<div
						class="w-full border border-2 border-primary"
						style="border-radius: 1rem"
					>
						<div
						class="m-2 rounded-2xl"
						id="map"
						style="height: 550px; border-radius: 1rem"
						></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- / Content -->
@endsection
@push('script')
<script>
	var map = L.map('map').setView([-8.537304773847266, 115.12583771558118], 10)

	L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
	  attribution: "&copy; GIS",
	}).addTo(map)

	if (navigator.geolocation) {
	const location = navigator.geolocation.getCurrentPosition(
	  (position) => {
		map.setView(
		  [position.coords.latitude, position.coords.longitude],
		  10
		)
	  }
	)} else {
	  alert('Geolocation is not supported by this browser.')
	}

	var markerClusters = L.markerClusterGroup();

	var micon = L.icon({
	  iconUrl: "../museum.png",
	  iconSize: [34, 34], // size of the icon
	  popupAnchor: [0, -30], // point from which the popup should open relative to the iconAnchor
	});

	@foreach ($spaces as $item)
	  
	  var marker = L.marker([{{ $item->lat }},{{ $item->long }}], {icon: micon},)
		.bindPopup(
		  `
			<div class="" style="width: 18rem;">
				<div id='carouselExample{{ $item->id }}' class='carousel slide' data-bs-ride='carousel'>
					<ol class='carousel-indicators'>
						@foreach ($item->images as $index => $image)
							<li data-bs-target='#carouselExample{{ $item->id }}' data-bs-slide-to='{{ $index }}' class='{{ $index === 0 ? "active" : "" }}'></li>
						@endforeach
					</ol>
					<div class='carousel-inner'>
						@foreach ($item->images as $index => $image)
							@php
								$activeClass = $index === 0 ? 'active' : '';
							@endphp
							<div class='carousel-item {{ $activeClass }}'>
								<img class='d-block w-100  cropped-image' src='/uploads/imgCover/{{ $image->path }}' alt='Image {{ $index + 1 }}'>
							</div>
						@endforeach
					</div>
					<a class='carousel-control-prev' href='#carouselExample{{ $item->id }}' role='button' data-bs-slide='prev'>
						<span class='carousel-control-prev-icon' aria-hidden='true'></span>
						<span class='visually-hidden'>Previous</span>
					</a>
					<a class='carousel-control-next' href='#carouselExample{{ $item->id }}' role='button' data-bs-slide='next'>
						<span class='carousel-control-next-icon' aria-hidden='true'></span>
						<span class='visually-hidden'>Next</span>
					</a>
				</div>
				<div class="py-2">
					<span class="fs-6 fw-bolder">{{ $item->nama }}</span> <span>({{ $item->jenis_museum->jenis }})</span>
				</div>
				<div class="border-top">
					<table class="table table-border">
						<tbody>
							<tr>
								<td colspan="2">{{ $item->desc }}</td>
							</tr>
							<tr>
								<th width="10px"><i class="bi bi-geo-alt" style="color: rgb(59, 130, 246);"></i></th>
								<td>{{ $item->alamat }}</td>
							</tr>
							<tr>
								<th width="10px"><i class="bi bi-telephone" style="color: rgb(59, 130, 246);"></i></th>
								<td>{{ $item->telepon }}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		  `
		);

	markerClusters.addLayer(marker);
	@endforeach


	map.addLayer(markerClusters);

  </script>
@endpush