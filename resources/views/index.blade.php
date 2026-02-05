@extends('layouts.frontend')
@section('content')

  <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="fade-up">
            <h1>Selamat Datang di Web GoTugas</h1>
            <p>Kerjakan Tugas Kalian di Sini</p>
          </div>
          <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="100">
            <img src="{{asset('assets/frontend/img/hero-img.png')}}" class="img-fluid animated" alt="">
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- Featured Services Section -->
     <section id="services" class="services section light-background">
  <div class="container section-title" data-aos="fade-up">
    <span>Kelas</span>
    <h2>Kelas Saya</h2>
    <p>Berikut daftar kelas yang telah kamu ikuti</p>
  </div>

  <div class="container">
    <div class="row gy-4">
      @forelse($kelasSaya as $kelas)
        <div class="col-lg-4 col-md-6" data-aos="fade-up">
          <div class="service-item position-relative">
            <div class="icon">
              <i class="bi bi-easel"></i>
            </div>
            <a href="{{ route('siswa.kelas.show', $kelas->id) }}" class="stretched-link">
              <h3>{{ $kelas->nama_kelas }}</h3>
              <h5>{{ $kelas->mata_pelajaran }}</h5>
            </a>
            <p>Bergabung sejak {{ $kelas->pivot->created_at->format('d M Y') }}</p>
          </div>
        </div>
      @empty
        <div class="col-12 text-center">
          <p>Kamu belum bergabung di kelas manapun.</p>
        </div>
      @endforelse
    </div>
  </div>
</section>
    <!-- /Featured Services Section -->

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  @endsection