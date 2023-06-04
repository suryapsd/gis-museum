@extends('user.layouts_user.app') 
@section('content')
<style>
    /* Style untuk crop image */
    .cropped-image {
      width: 100%;
      height: 150px;
      object-fit: cover;
    }
	.cropped-image-modal {
      width: 100%;
      height: 250px;
      object-fit: cover;
    }
</style>
<div class="site-blocks-cover overlay" style="background-color: rgba(0, 0, 0, 0.8); position: relative;">
    <img src="/uploads/imgCover/{{ $museum->images[0]->path }}" alt="Background Image" style="filter: brightness(0.3); object-fit: cover; width: 100%; height: 100%; position: absolute; top: 0; left: 0;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 mt-lg-5 text-center">
                <h1 class="text-uppercase" data-aos="fade-up">{{$museum->nama}}</h1>
				<p class="desc" data-aos="fade-up" data-aos-delay="100">
                    ({{$museum->jenis_museum->jenis}})
                </p>
                <p class="mb-5 desc" data-aos="fade-up" data-aos-delay="100">
                    {{$museum->desc}}
                </p>
            </div>
        </div>
    </div>
    <a href="#galeri" class="mouse smoothscroll">
        <span class="mouse-icon">
            <span class="mouse-wheel"></span>
        </span>
    </a>
</div>

<section class="site-section" id="galeri">
	<div class="container">
		<div class="row mb-5 border-bottom bg-light">
			<div class="col-12 text-center" data-aos="fade">
				<h2 class="section-title mb-3">Galeri Museum</h2>
				<p class="desc" data-aos="fade-up" data-aos-delay="100">Galeri merupakan ruang pameran yang dirancang secara khusus untuk menampilkan koleksi atau karya seni dengan cara yang informatif dan estetis. Tujuan utama galeri adalah memberikan pengalaman yang mendalam kepada pengunjung, memungkinkan mereka untuk belajar, menghargai, dan merenungkan karya seni atau artefak yang dipamerkan.</p>
			</div>
		</div>
		<div class="row align-items-center justify-content-center text-center items-center">
			@foreach ($galeri as $galeris)
				<div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up">
					<div class="unit-4">
						<div class="unit-4-icon mr-4">
							<span class="text-primary flaticon-startup"></span>
						</div>
						<div>
							<h3>{{$galeris->nama}}</h3>
							<p>
								{{$galeris->desc}}
							</p>
							<p>
								<a href="#">Learn More</a>
							</p>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</section>

<section class="site-section border-bottom bg-light" id="koleksi">
	<div class="container">
		<div class="row mb-3">
			<div class="col-12 text-center" data-aos="fade">
				<h2 class="section-title mb-3">Koleksi Galeri</h2>
				<p class="desc" data-aos="fade-up" data-aos-delay="100">Koleksi museum bisa mencakup berbagai jenis benda, termasuk lukisan, patung, fotografi, arsitektur, tekstil, artefak sejarah, artefak arkeologi, spesimen alam, benda-benda etnografis, dokumentasi sejarah, dan masih banyak lagi.</p>
				<p class="desc" data-aos="fade-up" data-aos-delay="100">Silahkan klik tombol dibawah ini untuk melihat koleksi pada galeri tertentu.</p>
			</div>
		</div>
		<div class="row justify-content-center mb-5" data-aos="fade-up">
			<div id="filters" class="filters text-center button-group col-md-7">
				<button class="btn btn-primary active" data-filter="*">All</button>
				@foreach ($galeri as $galeris)
					<button class="btn btn-primary" data-filter=".{{$galeris->id}}">{{$galeris->nama}}</button>
				@endforeach
			</div>
		</div>
		<div id="posts" class="row no-gutter">
			@foreach ($galeri as $galeris)
				@foreach ($galeris->koleksis as $koleksi)
					<div class="item {{$koleksi->galeri_id}} col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="">
						<div class="team-member card">
							<img src="/uploads/imgCover/{{ $koleksi->koleksi_images[0]->path }}" alt="Image" class="img-fluid cropped-image">
							<div class="p-3 text-center">
								<h3>{{ $koleksi->nama }} <span class="desc">({{ date('Y', strtotime($koleksi->tahun)) }})</span></h3>
								<span class="position">{{ $koleksi->artist }}<br></span>
								{{-- <p class="desc">{!!  Str::words($koleksi->desc, 5) !!}</p> --}}
								<!-- Button trigger modal -->
								<!-- Button trigger modal -->
								<button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $koleksi->id }}">
									Lihat Detail
								</button>
								
								<!-- Modal -->
							</div>
						</div>
					</div>
					<div class="modal fade" id="exampleModal{{ $koleksi->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
						<div class="modal-content">
							<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Detail Koleksi</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
							</div>
							<div class="modal-body">
								<div id='carouselExample{{ $koleksi->id }}' class='carousel slide' data-bs-ride='carousel'>
									<ol class='carousel-indicators'>
										@foreach ($koleksi->koleksi_images as $index => $image)
											<li data-bs-target='#carouselExample{{ $koleksi->id }}' data-bs-slide-to='{{ $index }}' class='{{ $index === 0 ? "active" : "" }}'></li>
										@endforeach
									</ol>
									<div class='carousel-inner'>
										@foreach ($koleksi->koleksi_images as $index => $image)
											@php
												$activeClass = $index === 0 ? 'active' : '';
											@endphp
											<div class='carousel-item {{ $activeClass }}'>
												<img class='d-block w-100 cropped-image-modal' src='/uploads/imgCover/{{ $image->path }}' alt='Image {{ $index + 1 }}'>
											</div>
										@endforeach
									</div>
									<a class='carousel-control-prev' href='#carouselExample{{ $koleksi->id }}' role='button' data-bs-slide='prev'>
										<span class='carousel-control-prev-icon' aria-hidden='true'></span>
									</a>
									<a class='carousel-control-next' href='#carouselExample{{ $koleksi->id }}' role='button' data-bs-slide='next'>
										<span class='carousel-control-next-icon' aria-hidden='true'></span>
									</a>
								</div>
								<div class="p-3 text-center">
									<h3>{{ $koleksi->nama }} <span class="desc">({{ date('Y', strtotime($koleksi->tahun)) }})</span></h3>
									<span class="position">{{ $koleksi->artist }}<br></span>
									<p class="desc">{{ $koleksi->desc }}</p>
								</div>
							</div>
						</div>
						</div>
					</div>
				@endforeach
			@endforeach
		</div>
	</div>
</section>

<section class="site-section border-bottom" id="pengurus">
	<div class="container">
		<div class="row mb-5 justify-content-center">
			<div class="col-md-8 text-center">
				<h2 class="section-title mb-3" data-aos="fade-up" data-aos-delay="">Pengurus Museum</h2>
			</div>
		</div>
		<div class="row align-items-center justify-content-center text-center items-center">
			@foreach ($pengurus as $penguruses)
				<div class="col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="">
					<div class="team-member">
						<figure>
						<img src="/uploads/imgCover/{{ $penguruses->image }}" alt="Image" class="img-fluid">
						</figure>
						<div class="p-3 text-center">
							<h3>{{ $penguruses->nama_pengurus }}</h3>
							<span class="position">{{ $penguruses->jabatan }}</span>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</section>

<section class="site-section bg-light" id="kontak" data-aos="fade">
	<div class="container">
		<div class="row mb-5">
			<div class="col-12 text-center">
				<h2 class="section-title mb-3">Contact Us</h2>
			</div>
		</div>
		<div class="row mb-5">
			<div class="col-md-4 text-center">
				<p class="mb-4">
					<span class="icon-room d-block h4 text-primary"></span>
					<span>203 Fake St. Mountain View, San Francisco, California, USA</span>
				</p>
			</div>
			<div class="col-md-4 text-center">
				<p class="mb-4">
					<span class="icon-phone d-block h4 text-primary"></span>
					<a href="#">+1 232 3235 324</a>
				</p>
			</div>
			<div class="col-md-4 text-center">
				<p class="mb-0">
					<span class="icon-mail_outline d-block h4 text-primary"></span>
					<a href="#">youremail@domain.com</a>
				</p>
			</div>
		</div>
	</div>
</section>
@endsection