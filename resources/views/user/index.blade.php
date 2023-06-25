@extends('user.layouts_user.app') 
@section('content')
<style>
    /* Style untuk crop image */
    .cropped-image {
      width: 100%;
      height: 150px;
      object-fit: cover;
    }
</style>
<div class="site-blocks-cover overlay" style="background-image: url(user/images/hero_2.jpg);" data-aos="fade" id="home-section">
	<div class="container">
		<div class="row align-items-center justify-content-center">
			<div class="col-md-12 mt-lg-5 text-center">
				<div class="w-full border border-2" style="border-radius: 1rem; border-color: #696CFF;">
                    <div class="m-2 rounded-2xl" id="map" style="height: 500px; border-radius: 1rem"></div>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('script')
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"
    ></script>

    <!-- Leaflet -->
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

        @foreach ($spaces as $item)
            var micon = L.icon({
            iconUrl: "/uploads/icon/{{ $item->icon }}",
            iconSize: [34, 34], // size of the icon
            popupAnchor: [0, -30], // point from which the popup should open relative to the iconAnchor
            });

            var marker = L.marker([{{ $item->lat }},{{ $item->long }}], {icon: micon})
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
                        </a>
                        <a class='carousel-control-next' href='#carouselExample{{ $item->id }}' role='button' data-bs-slide='next'>
                            <span class='carousel-control-next-icon' aria-hidden='true'></span>
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
                    <a href="/detail-museum/{{ $item->id }}">Detail Museum</a>
                </div>
                `
                );
            markerClusters.addLayer(marker);

        @endforeach

        map.addLayer(markerClusters);

    </script>
@endpush