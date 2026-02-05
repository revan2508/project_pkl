@extends('layouts.frontend')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    {{-- Title --}}
                    <div class="text-center mb-4">
                        <h4 class="fw-bold mb-1">Join Kelas</h4>
                        <small class="text-muted">
                            Masukkan kode kelas dari guru
                        </small>
                    </div>

                    {{-- Error --}}
                    @if(session('error'))
                        <div class="alert alert-danger small text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Form --}}
                    <form method="POST" action="{{ route('siswa.kelas.join.proses') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted">
                                Kode Kelas
                            </label>
                            <input
                                type="text"
                                name="kode_kelas"
                                class="form-control text-center fw-semibold"
                                placeholder="Contoh: A9F3KD"
                                required
                            >
                        </div>

                        <div class="d-grid">
                            <button type="submit"
                                    class="btn btn-dark rounded-pill py-2">
                                Gabung Kelas
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
