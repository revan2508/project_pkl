@extends('layouts.guru')

@section('content')
<div class="container-fluid mt-4">

    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-8">

            {{-- TITLE --}}
            <div class="mb-3">
                <h4 class="fw-bold mb-1">Edit Kelas</h4>
                <small class="text-muted">Ubah nama kelas lalu simpan</small>
            </div>

            {{-- FORM CARD --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <form method="POST"
                          action="{{ route('guru.kelas.update', $kelas) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Nama Kelas
                            </label>
                            <input
                                type="text"
                                name="nama_kelas"
                                class="form-control form-control-lg @error('nama_kelas') is-invalid @enderror"
                                value="{{ old('nama_kelas', $kelas->nama_kelas) }}"
                                required
                            >
                            @error('nama_kelas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('guru.kelas.index') }}"
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
