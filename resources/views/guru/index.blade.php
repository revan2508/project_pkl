@extends('layouts.guru')

@section('content')
<div class="container-fluid mt-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h3 class="fw-bold mb-1">Dashboard Guru</h3>
        <small class="text-muted">
            Selamat datang, {{ Auth::user()->name }}
        </small>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Total Kelas</small>
                    <h4 class="fw-bold mb-0">{{ $totalKelas ?? '-' }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Total Mapel</small>
                    <h4 class="fw-bold mb-0">{{ $totalMapel ?? '-' }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Total Tugas</small>
                    <h4 class="fw-bold mb-0">{{ $totalTugas ?? '-' }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted">Belum Dinilai</small>
                    <h4 class="fw-bold mb-0">{{ $belumDinilai ?? '-' }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- QUICK ACCESS --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h6 class="fw-semibold mb-3">Akses Cepat</h6>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('guru.kelas.index') }}"
                   class="btn btn-outline-dark btn-sm px-3">
                    Kelola Kelas
                </a>

                <a href="{{ route('guru.mapel.index') }}"
                   class="btn btn-outline-dark btn-sm px-3">
                    Kelola Mapel
                </a>

                <a href="{{ route('guru.tugas.pilihKelas') }}"
                   class="btn btn-outline-dark btn-sm px-3">
                    Kelola Tugas
                </a>

            </div>
        </div>
    </div>

</div>
@endsection
