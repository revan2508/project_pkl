@extends('layouts.guru')

@section('content')
<div class="container-fluid mt-4">

    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-8">

            {{-- TITLE --}}
            <div class="mb-3">
                <h4 class="fw-bold mb-1">Edit Mata Pelajaran</h4>
                <small class="text-muted">Ubah nama mata pelajaran lalu simpan</small>
            </div>

            {{-- FORM CARD --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <form action="{{ route('guru.mapel.update', $mapel->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- KELAS (READ ONLY) --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Kelas
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                value="{{ $mapel->kelas->pluck('nama_kelas')->join(', ') ?: '-' }}"
                                disabled
                            >
                        </div>

                        {{-- NAMA MAPEL --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Nama Mata Pelajaran
                            </label>
                            <input
                                type="text"
                                name="nama_mapel"
                                class="form-control form-control-lg @error('nama_mapel') is-invalid @enderror"
                                value="{{ old('nama_mapel', $mapel->nama_mapel) }}"
                                placeholder="Contoh: Informatika"
                                required
                            >
                            @error('nama_mapel')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- ACTION --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('guru.mapel.index') }}"
                               class="btn btn-outline-secondary px-4">
                                Batal
                            </a>
                            <button type="submit"
                                    class="btn btn-dark px-4">
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
