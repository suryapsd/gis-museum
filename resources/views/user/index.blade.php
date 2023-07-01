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
	<div class="pt-2">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-12 mt-lg-5 text-center">
                <div class="mt-12 " id="map" style="height: 90vh;"></div>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('script')
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="{{ asset('user/leaflet-routing-machine/dist/leaflet-routing-machine.js') }}"></script>
    <script src="{{ asset('user/leaflet-panel-layers-master/src/leaflet-panel-layers.js') }}"></script>

    <script src="{{ asset('user/leaflet-routing-machine/examples/Control.Geocoder.js') }}"></script>

    <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"
    ></script>

    <!-- Leaflet -->
    <script>
        var map = L.map('map').setView([-8.537304773847266, 115.12583771558118], 10)

        L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
        attribution: "&copy; GIS",
        }).addTo(map)

        var markerClusters = L.markerClusterGroup();

        // if (navigator.geolocation) {
        //     const location = navigator.geolocation.getCurrentPosition(
        //     (position) => {
        //         map.setView(
        //         [position.coords.latitude, position.coords.longitude],
        //         10
        //         )

        //         var marker_position = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map)
        //                 .bindPopup('You are here!')
        //                 .openPopup();
                
        //         // markerClusters.addLayer(marker_position);
        //     },
        //     (error) => {
        //     console.error('Error accessing geolocation:', error);
        //     });
        // } else {
        // alert('Geolocation is not supported by this browser.');
        // }

        var icons = {};
        @foreach ($spaces as $item)
            icons["{{ $item->icon }}"] = L.icon({
            iconUrl: "/uploads/icon/{{ $item->icon }}",
            iconSize: [34, 34], // size of the icon
            popupAnchor: [0, -30], // point from which the popup should open relative to the iconAnchor
            });

            var marker = L.marker([{{ $item->lat }},{{ $item->long }}], {icon: icons["{{ $item->icon }}"]})
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
                    <a href='javascript:void(0)' onclick="return keSini({{ $item->lat }}, {{ $item->long }})">Pergi kesini</a>
                </div>
                `
                );
            markerClusters.addLayer(marker);

        @endforeach

        var control;

        var icon_start = L.icon({
            iconUrl: "/uploads/icon/museum.png",
            iconSize: [34, 34], // size of the icon
            popupAnchor: [0, -30], // point from which the popup should open relative to the iconAnchor
        });
        
        var icon_end = L.icon({
            iconUrl: "/uploads/icon/icon_end.png",
            iconSize: [34, 34], // size of the icon
            popupAnchor: [0, -30], // point from which the popup should open relative to the iconAnchor
        });
        
        if (navigator.geolocation) {
            const location = navigator.geolocation.getCurrentPosition(
            (position) => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                control = L.Routing.control({
                waypoints: [
                    L.latLng(latitude, longitude)
                ],
                createMarker: function(i, waypoint, n) {
                    // Gunakan ikon kustom pada waypoint pertama
                    if (i === 0) {
                        var newmarker = L.marker(waypoint.latLng, { icon: icon_end })
                            .addTo(map)
                            .bindPopup('Anda berada disini.')
                            .openPopup();

                        // markerClusters.addLayer(newmarker);
                        
                        return newmarker;
                    }
                    // Gunakan ikon default pada waypoint lainnya
                    return L.marker(waypoint.latLng, { icon: icon_end });
                },
                geocoder: L.Control.Geocoder.nominatim(),
                routeWhileDragging: true,
                reverseWaypoints: true,
                showAlternatives: true,
                altLineOptions: {
                    styles: [
                    { color: 'black', opacity: 0.15, weight: 9 },
                    { color: 'white', opacity: 0.8, weight: 6 },
                    { color: 'blue', opacity: 0.5, weight: 2 }
                    ]
                }
                });

                control.addTo(map);

            },
            (error) => {
            console.error('Error accessing geolocation:', error);
            });
        } else {
            alert('Geolocation is not supported by this browser.');
        }

        function keSini(lat, lng){
            var latLng=L.latLng(lat, lng);
            control.spliceWaypoints(control.getWaypoints().length - 1, 1, latLng);
        }

        // map.on("click", function(e){
        //     marker = new L.marker(e.latlng);
        //     var lat = e.latlng.lat;
        //     var lng = e.latlng.lng;

        //     var latLng=L.latLng(lat, lng);
        //     control.spliceWaypoints(control.getWaypoints().length - 0, 1, latLng);
        // });
        map.addLayer(markerClusters);

    </script>
@endpush