@extends('layouts.guru')

@section('content')
<div class="container-fluid py-4">

    <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-8 col-md-10">

            {{-- HEADER --}}
            <div class="text-center mb-4">
                <h3 class="fw-bold mb-1">Tambah Tugas</h3>
                <div class="text-muted">
                    Kelas: {{ $kelas->nama_kelas }}
                </div>
            </div>

            {{-- CARD --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">

                    <form action="{{ route('guru.tugas.store', $kelas->id) }}" method="POST">
                        @csrf

                        {{-- MAPEL --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Mata Pelajaran</label>
                            <select name="mapel_id"
                                    class="form-select form-select-lg @error('mapel_id') is-invalid @enderror"
                                    required>
                                <option value="">Pilih mata pelajaran</option>
                                @foreach($kelas->mapel as $mapel)
                                    <option value="{{ $mapel->id }}"
                                        {{ old('mapel_id') == $mapel->id ? 'selected' : '' }}>
                                        {{ $mapel->nama_mapel }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mapel_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- JUDUL --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Judul Tugas</label>
                            <input type="text"
                                   name="judul"
                                   class="form-control form-control-lg @error('judul') is-invalid @enderror"
                                   placeholder="Contoh: Penjajahan Belanda"
                                   value="{{ old('judul') }}"
                                   required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- PERINTAH --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Perintah</label>
                            <input type="text"
                                   name="perintah"
                                   class="form-control form-control-lg @error('perintah') is-invalid @enderror"
                                   placeholder="Contoh: Jelaskan secara singkat"
                                   value="{{ old('perintah') }}"
                                   required>
                            @error('perintah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- DESKRIPSI --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Deskripsi <span class="text-muted">(boleh tempel link)</span>
                            </label>
                            <textarea name="deskripsi"
                                      rows="4"
                                      class="form-control @error('deskripsi') is-invalid @enderror"
                                      placeholder="Contoh: https://drive.google.com/..."
                                      required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- DEADLINE & TIPE --}}
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Deadline (Tanggal & Jam)
                                </label>
                                <input type="datetime-local"
                                       name="deadline"
                                       class="form-control form-control-lg @error('deadline') is-invalid @enderror"
                                       value="{{ old('deadline') }}"
                                       required>
                                @error('deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Tipe Tugas
                                </label>
                                <select name="tipe"
                                        class="form-select form-select-lg @error('tipe') is-invalid @enderror"
                                        required>
                                    <option value="">Pilih tipe</option>
                                    <option value="individu" {{ old('tipe') == 'individu' ? 'selected' : '' }}>
                                        Individu
                                    </option>
                                    <option value="kelompok" {{ old('tipe') == 'kelompok' ? 'selected' : '' }}>
                                        Kelompok
                                    </option>
                                </select>
                                @error('tipe')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('guru.tugas.index', $kelas->id) }}"
                               class="btn btn-outline-secondary px-4">
                                Batal
                            </a>
                            <button class="btn btn-dark px-4">
                                Simpan Tugas
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
