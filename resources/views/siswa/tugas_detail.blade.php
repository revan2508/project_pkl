@extends('layouts.frontend')

@section('content')
<div class="container py-4" style="max-width: 900px">

    {{-- Kembali --}}
    <div class="mb-3">
        <a href="{{ url()->previous() }}"
           class="btn btn-outline-secondary btn-sm rounded-pill">
            ← Kembali
        </a>
    </div>

    <div class="card border-0 shadow rounded-4">
        <div class="card-body p-4 p-md-5">

            {{-- JUDUL --}}
            <h3 class="fw-bold mb-4 text-capitalize">
                {{ $tugas->judul }}
            </h3>

            {{-- PERINTAH --}}
            <div class="mb-4 p-3 rounded-3 border bg-light">
                <div class="fw-semibold mb-1">📌 Perintah</div>
                <div class="text-muted">
                    {{ $tugas->perintah }}
                </div>
            </div>

            {{-- DESKRIPSI --}}
            <div class="mb-3">
                <div class="fw-semibold mb-1">📎 Deskripsi</div>

                @php
                    $deskripsi = e($tugas->deskripsi);
                    $deskripsi = preg_replace(
                        '/(https?:\/\/[^\s]+)/',
                        '<a href="$1" target="_blank" class="link-primary fw-semibold">$1</a>',
                        $deskripsi
                    );
                @endphp

                <div class="text-muted" style="word-break: break-word;">
                    {!! nl2br($deskripsi) !!}
                </div>
            </div>

            {{-- DEADLINE --}}
            <div class="mb-4 text-muted">
                <strong>⏰ Deadline:</strong>
                {{ \Carbon\Carbon::parse($tugas->deadline)->translatedFormat('d F Y H:i') }}
            </div>

            <hr>

            @php
                use Carbon\Carbon;

                $now = Carbon::now();
                $deadline = Carbon::parse($tugas->deadline);

                $pengumpulan = $tugas->pengumpulan()
                    ->where('siswa_id', auth()->id())
                    ->first();
            @endphp

            {{-- DEADLINE LEWAT --}}
            @if ($deadline < $now && !$pengumpulan)
                <div class="alert alert-warning mt-4">
                    ⛔ Deadline tugas sudah lewat. Kamu tidak bisa mengumpulkan tugas ini.
                </div>

            {{-- SUDAH NGUMPUL --}}
            @elseif ($pengumpulan)
                <div class="alert alert-info mt-4">
                    <strong>Status:</strong>

                    @if ($pengumpulan->status === 'dikirim')
                        <div class="mt-1">
                            Sudah dikumpulkan, menunggu penilaian.
                        </div>
                    @else
                        <div class="mt-1">
                            Sudah dinilai
                        </div>
                        <h5 class="fw-bold text-success mt-2">
                            Nilai: {{ $pengumpulan->nilai }}
                        </h5>
                    @endif

                    <a href="{{ asset('storage/'.$pengumpulan->file) }}"
                       target="_blank"
                       class="btn btn-outline-dark btn-sm mt-3">
                        📂 Lihat File
                    </a>

                    @if ($pengumpulan->status === 'dikirim')
                        <div class="mt-3 d-flex gap-2 flex-wrap">
                            <a href="{{ route('siswa.tugas.edit', $pengumpulan->id) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('siswa.tugas.batalkan', $pengumpulan->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    Batalkan
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

            {{-- FORM KUMPUL --}}
            @else
                <h5 class="fw-bold mb-3">📤 Kumpulkan Tugas</h5>

                <form method="POST"
                      action="{{ route('siswa.tugas.kumpulkan', $tugas->id) }}"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            File (JPG, PNG, DOCX, PDF, ZIP • Maks 2MB)
                        </label>
                        <input type="file"
                               name="file"
                               class="form-control @error('file') is-invalid @enderror"
                               accept=".jpg,.jpeg,.png,.docx,.pdf,.zip"
                               required>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Catatan (opsional)
                        </label>
                        <textarea name="catatan"
                                  rows="4"
                                  class="form-control">{{ old('catatan') }}</textarea>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-success px-4">
                            Kumpulkan
                        </button>
                    </div>
                </form>
            @endif

        </div>
    </div>
</div>
@endsection
