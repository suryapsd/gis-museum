<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="{{ asset('admin/assets/img/favicon/earth-grid.png') }}" />

    <title>Museum</title>

    <!-- Boostrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    {{-- cdn leaflet search --}}
    <link rel="stylesheet" href="../src/leaflet-search.css" />
    <script src="../src/leaflet-search.js"></script>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.1/leaflet.markercluster.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.1/MarkerCluster.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.1/MarkerCluster.Default.css" />   

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Boostrap Icon -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
      integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e"
      crossorigin="anonymous"
    />

    <style>
      /* Style untuk crop image */
      .cropped-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
      }
    </style>
  </head>
  <body>
    <div class="hero overlay" style="background-image: url(./user/images/57.jpg); background-size: cover;">
      <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <a class="navbar-brand" href="#">Museum</a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            </ul>
            <a href="" class="btn btn-primary" style="border-radius: 5rem;">Login</a>
          </div>
        </div>
      </nav>
      
      <div class="container py-4">
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

      var micon = L.icon({
        iconUrl: "museum.png",
        iconSize: [34, 34], // size of the icon
        popupAnchor: [0, -30], // point from which the popup should open relative to the iconAnchor
      });

      @foreach ($spaces as $item)
        var marker = L.marker([{{ $item->lat }},{{ $item->long }}], {icon: micon})
        // marker.on('click', function(e){
        //   $("#modalCreate").modal("show");
        //   $(".navbar-collapse.in").collapse("hide");
        //   // or whatever that opens the right modal window
        // });
          .bindPopup(
            `
            <div class="" style="width: 18rem;">
                <img src="/uploads/imgCover/{{ $item->images[0]->path }}" class="card-img-top mt-2 cropped-image" alt="...">
                <div class="py-2">
                  <span class="fs-6 fw-bolder">{{$item->nama}}</span> <span>({{$item->jenis_museum->jenis}})</span>
                </div>
                <div class="border-top">
                  <table class="table table-border">
                    <tbody>
                      <tr>
                        <td colspan="2">{{$item->desc}}</td>
                      </tr>
                      <tr>
                        <th width="10px"><i class="bi bi-geo-alt" style="color: rgb(59 130 246);"></i></th>
                        <td>{{$item->alamat}}, {{$item->lat}}, {{$item->long}}</td>
                      </tr>
                      <tr>
                        <th width="10px"><i class="bi bi-telephone" style="color: rgb(59 130 246);"></i></th>
                        <td>{{$item->telepon}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <a href="/detailmuseum" class="btn btn-outline-primary btn-sm mt-1 mb-2">
                  Lihat Detail
                </a>
            </div>
            `
          );
      markerClusters.addLayer(marker);
      @endforeach
      
      map.addLayer(markerClusters);

      var datas = [    
      @foreach ($spaces as $key => $value) 
          {"loc":[{{ $value->lat }},{{ $value->long }}], "title": '{!! $value->nama !!}'},
      @endforeach            
      ];

      
    </script>
  </body>
</html>
