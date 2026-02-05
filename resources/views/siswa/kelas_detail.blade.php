@extends('layouts.frontend')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="mb-4">
        <h3 class="fw-bold mb-1">
            {{ $kelas->nama_kelas }}
        </h3>
        <small class="text-muted">
            Total Tugas: {{ $tugas->count() }}
        </small>
    </div>

    {{-- List Tugas --}}
    <div class="row g-4">
        @forelse ($tugas as $t)
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">

                    <div class="card-body d-flex flex-column">

                        {{-- Judul --}}
                        <h5 class="fw-semibold mb-2">
                            {{ $t->judul }}
                        </h5>

                        {{-- Deskripsi --}}
                        <p class="text-muted small flex-grow-1">
                            {{ Str::limit($t->deskripsi, 80) }}
                        </p>

                        {{-- Footer --}}
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">
                                Deadline:
                                {{ \Carbon\Carbon::parse($t->deadline)->format('d M Y') }}
                            </small>

                            <a href="{{ route('siswa.tugas.show', $t->id) }}"
                               class="btn btn-dark btn-sm rounded-pill px-3">
                                Lihat
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light border text-center py-4 rounded-4">
                    Belum ada tugas di kelas ini
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection
