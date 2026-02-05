@extends('layouts.frontend')

@section('title', 'Detail Tugas')

@section('content')
<div class="container py-4">

    {{-- Back --}}
    <div class="mb-3">
        <a href="{{ url()->previous() }}"
           class="btn btn-outline-secondary btn-sm rounded-pill">
            ← Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            {{-- Judul --}}
            <h4 class="fw-bold mb-2">
                {{ $tugas->judul }}
            </h4>

            <p class="text-muted">
                {{ $tugas->deskripsi }}
            </p>

            <p class="small text-muted mb-4">
                Deadline:
                {{ \Carbon\Carbon::parse($tugas->deadline)->translatedFormat('d F Y H:i') }}
            </p>

            @php
                $pengumpulan = $tugas->pengumpulan()
                    ->where('siswa_id', auth()->id())
                    ->first();
            @endphp

            {{-- SUDAH KUMPUL --}}
            @if ($pengumpulan)
                <div class="alert alert-light border rounded-3">
                    <strong>Status Pengumpulan</strong>
                    <div class="mt-2">

                        @if ($pengumpulan->status === 'dikirim')
                            <span class="badge bg-warning text-dark">
                                Menunggu Penilaian
                            </span>
                        @elseif ($pengumpulan->status === 'dinilai')
                            <span class="badge bg-success">
                                Sudah Dinilai
                            </span>
                            <div class="mt-2 fw-semibold">
                                Nilai: {{ $pengumpulan->nilai }}
                            </div>
                        @endif

                        <div class="mt-3">
                            <a href="{{ asset('storage/' . $pengumpulan->file) }}"
                               target="_blank"
                               class="btn btn-outline-dark btn-sm rounded-pill">
                                Lihat File
                            </a>
                        </div>
                    </div>
                </div>

            {{-- BELUM KUMPUL --}}
            @else
                <form method="POST"
                      action="{{ route('siswa.tugas.kumpulkan', $tugas->id) }}"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Upload File
                        </label>
                        <input type="file"
                               name="file"
                               class="form-control"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Catatan (opsional)
                        </label>
                        <textarea name="catatan"
                                  rows="4"
                                  class="form-control"
                                  placeholder="Tulis catatan jika perlu..."></textarea>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-dark rounded-pill px-4">
                            Kumpulkan
                        </button>
                    </div>
                </form>
            @endif

        </div>
    </div>
</div>
@endsection
