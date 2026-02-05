@extends('layouts.guru')

@section('content')
<div class="container-fluid mt-4">

    {{-- TITLE --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Pilih Kelas</h4>
        <small class="text-muted">Pilih kelas untuk melihat daftar tugas</small>
    </div>

    {{-- LIST KELAS --}}
    <div class="row">
        @forelse($kelas as $k)
            <div class="col-md-4 mb-3">
                <a href="{{ route('guru.tugas.index', $k->id) }}"
                   class="card border-0 shadow-sm text-decoration-none h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="fw-semibold text-dark">
                            {{ $k->nama_kelas }}
                        </div>
                        <span class="text-muted small">
                            Lihat →
                        </span>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center text-muted py-5">
                        Belum ada kelas
                    </div>
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection
