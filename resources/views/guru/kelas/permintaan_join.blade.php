@extends('layouts.guru')

@section('content')
<div class="container-fluid mt-4">

    {{-- TITLE --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Permintaan Join Kelas</h4>
        <small class="text-muted">Kelola siswa yang ingin bergabung ke kelas</small>
    </div>

    @forelse($kelasSaya as $kelas)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">

                {{-- KELAS HEADER --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="fw-semibold mb-0">{{ $kelas->nama_kelas }}</h6>
                        <small class="text-muted">Kode: {{ $kelas->kode_kelas }}</small>
                    </div>
                </div>

                {{-- LIST PERMINTAAN --}}
                @forelse($kelas->permintaanJoin as $permintaan)
                    <div class="d-flex justify-content-between align-items-center py-2 border-top">
                        <div>
                            <div class="fw-semibold">
                                {{ $permintaan->siswa->nama }}
                            </div>
                            <small class="text-muted">
                                {{ $permintaan->siswa->email }}
                            </small>
                        </div>

                        <div class="d-flex gap-2">
                            <form method="POST"
                                  action="{{ route('guru.terimaPermintaan', $permintaan->id) }}">
                                @csrf
                                <button class="btn btn-dark btn-sm px-3">
                                    Terima
                                </button>
                            </form>

                            <form method="POST"
                                  action="{{ route('guru.tolakPermintaan', $permintaan->id) }}">
                                @csrf
                                <button class="btn btn-outline-secondary btn-sm px-3">
                                    Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-muted small py-3">
                        Tidak ada permintaan join untuk kelas ini.
                    </div>
                @endforelse

            </div>
        </div>
    @empty
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center text-muted py-5">
                Tidak ada permintaan join kelas.
            </div>
        </div>
    @endforelse

</div>
@endsection
