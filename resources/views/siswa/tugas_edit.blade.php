@extends('layouts.frontend')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Back --}}
            <div class="mb-3">
                <a href="{{ url()->previous() }}"
                   class="btn btn-outline-secondary btn-sm rounded-pill">
                    ← Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-lg-5">

                    {{-- Header --}}
                    <div class="mb-4">
                        <h4 class="fw-bold mb-1">Edit Pengumpulan Tugas</h4>
                        <small class="text-muted">
                            Perbarui file atau catatan pengumpulan
                        </small>
                    </div>

                    <form method="POST"
                          action="{{ route('siswa.tugas.update', $pengumpulan->id) }}"
                          enctype="multipart/form-data">
                        @csrf

                        {{-- File Saat Ini --}}
                        @if($pengumpulan->file)
                            <div class="border rounded-3 p-3 mb-4 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="small text-muted">File saat ini</div>
                                    <div class="fw-semibold">
                                        {{ basename($pengumpulan->file) }}
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $pengumpulan->file) }}"
                                   target="_blank"
                                   class="btn btn-outline-dark btn-sm rounded-pill">
                                    Lihat
                                </a>
                            </div>
                        @endif

                        {{-- Upload --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Ganti File (opsional)
                            </label>
                            <input type="file"
                                   name="file"
                                   class="form-control">
                            <small class="text-muted">
                                Kosongkan jika tidak ingin mengganti file
                            </small>
                        </div>

                        {{-- Catatan --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Catatan / Deskripsi
                            </label>
                            <textarea name="catatan"
                                      rows="5"
                                      class="form-control"
                                      placeholder="Tambahkan catatan jika perlu...">{{ $pengumpulan->catatan }}</textarea>
                        </div>

                        {{-- Action --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ url()->previous() }}"
                               class="btn btn-outline-secondary rounded-pill px-4">
                                Batal
                            </a>
                            <button class="btn btn-dark rounded-pill px-4">
                                Simpan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
