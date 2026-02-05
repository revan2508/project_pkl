@extends('layouts.guru')

@section('content')
<div class="container-fluid mt-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Daftar Tugas
            </h4>
            <small class="text-muted">
                Kelas: {{ $kelas->nama_kelas }}
            </small>
        </div>
        <a href="{{ route('guru.tugas.create', $kelas->id) }}"
           class="btn btn-dark btn-sm px-3">
            + Tambah Tugas
        </a>
    </div>

    {{-- TABLE --}}
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-uppercase small text-muted">
                    <tr>
                        <th width="5%">No</th>
                        <th>Mapel</th>
                        <th>Judul</th>
                        <th>Deadline</th>
                        <th>Tipe</th>
                        <th class="text-center" width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($tugas as $t)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $t->mapel->nama_mapel }}</td>
                    <td class="fw-semibold">{{ $t->judul }}</td>
                    <td>{{ \Carbon\Carbon::parse($t->deadline)->format('d M Y') }}</td>
                    <td>
                        <span class="badge bg-light text-dark border">
                            {{ ucfirst($t->tipe) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('guru.tugas.edit', $t->id) }}"
                        class="btn btn-outline-secondary btn-sm">Edit</a>

                        <a href="{{ route('guru.tugas.pengumpulan', $t->id) }}"
                        class="btn btn-outline-dark btn-sm">Pengumpulan</a>

                        <form action="{{ route('guru.tugas.destroy', $t->id) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Yakin hapus tugas ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        Belum ada tugas
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
