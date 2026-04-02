@extends('layouts.guru')

@section('content')
<div class="container-fluid mt-4">

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            {{-- TITLE --}}
            <div class="mb-3">
                <h4 class="fw-bold mb-1">Edit Tugas</h4>
                <small class="text-muted">
                    Kelas: {{ $tugas->kelas->nama_kelas }}
                </small>
            </div>

            {{-- FORM CARD --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <form action="{{ route('guru.tugas.update', $tugas->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- MAPEL (READ ONLY) --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Mata Pelajaran
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                value="{{ $tugas->mapel->nama_mapel }}"
                                disabled
                            >
                        </div>

                        {{-- JUDUL --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Judul Tugas
                            </label>
                            <input
                                type="text"
                                name="judul"
                                class="form-control form-control-lg @error('judul') is-invalid @enderror"
                                value="{{ old('judul', $tugas->judul) }}"
                                required
                            >
                            @error('judul')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- PERINTAH --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Perintah
                            </label>
                            <input
                                type="text"
                                name="perintah"
                                class="form-control @error('perintah') is-invalid @enderror"
                                value="{{ old('perintah', $tugas->perintah) }}"
                                required
                            >
                            @error('perintah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- DESKRIPSI --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Deskripsi
                            </label>
                            <textarea
                                name="deskripsi"
                                rows="4"
                                class="form-control @error('deskripsi') is-invalid @enderror"
                                required>{{ old('deskripsi', $tugas->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- DEADLINE & TIPE --}}
                        <div class="row">
                              {{-- DEADLINE --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Deadline (Tanggal & Jam)
                                </label>

                                <input type="datetime-local"
                                       id="deadline"
                                       name="deadline"
                                       class="form-control form-control-lg @error('deadline') is-invalid @enderror"
                                       value="{{ old('deadline') }}"
                                       min="{{ now()->format('Y-m-d\TH:i') }}"
                                       required>

                                <small id="errorDeadline" class="text-danger d-none">
                                    Deadline harus lebih dari waktu sekarang!
                                </small>

                                @error('deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">
                                    Tipe Tugas
                                </label>
                                <select
                                    name="tipe"
                                    class="form-select @error('tipe') is-invalid @enderror"
                                    required>
                                    <option value="individu"
                                        {{ old('tipe', $tugas->tipe) === 'individu' ? 'selected' : '' }}>
                                        Individu
                                    </option>
                                    <option value="kelompok"
                                        {{ old('tipe', $tugas->tipe) === 'kelompok' ? 'selected' : '' }}>
                                        Kelompok
                                    </option>
                                </select>
                                @error('tipe')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('guru.tugas.index', $tugas->kelas_id) }}"
                               class="btn btn-outline-secondary px-4">
                                Batal
                            </a>
                            <button class="btn btn-dark px-4">
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
