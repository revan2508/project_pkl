@extends('layouts.guru')

@section('content')
<div class="container-fluid mt-4">

    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-8">

            {{-- TITLE --}}
            <div class="mb-3">
                <h4 class="fw-bold mb-1">Tambah Mapel ke Kelas</h4>
                <small class="text-muted">
                    Kelas: {{ $kelas->nama_kelas }}
                </small>
            </div>

            {{-- FORM CARD --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <form method="POST"
                          action="{{ route('guru.kelas.mapel.store', $kelas->id) }}">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Mata Pelajaran
                            </label>
                            <select name="mapel_id"
                                    class="form-select @error('mapel_id') is-invalid @enderror"
                                    required>
                                <option value="">Pilih mata pelajaran</option>
                                @foreach ($mapel as $m)
                                    <option value="{{ $m->id }}"
                                        {{ old('mapel_id') == $m->id ? 'selected' : '' }}>
                                        {{ $m->nama_mapel }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mapel_id')
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
