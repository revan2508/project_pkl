@extends('layouts.guru')

@section('content')
<div class="container-fluid mt-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Daftar Mata Pelajaran</h4>
            <small class="text-muted">Kelola mata pelajaran yang diajar</small>
        </div>
        <a href="{{ route('guru.mapel.create') }}"
           class="btn btn-dark btn-sm px-3">
            + Tambah Mapel
        </a>
    </div>

    {{-- TABLE --}}
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-uppercase small text-muted">
                    <tr>
                        <th width="5%">No</th>
                        <th>Kelas</th>
                        <th>Nama Mapel</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mapel as $m)
                        <tr>
                            <td class="text-muted">{{ $loop->iteration }}</td>

                            {{-- KELAS --}}
                            <td>
                                @forelse ($m->kelas as $k)
                                    <span class="badge bg-light text-dark border me-1 mb-1">
                                        {{ $k->nama_kelas }}
                                    </span>
                                @empty
                                    <span class="text-muted">-</span>
                                @endforelse
                            </td>

                            <td class="fw-semibold">
                                {{ $m->nama_mapel }}
                            </td>

                            <td class="text-center">
                                <a href="{{ route('guru.mapel.edit', $m->id) }}"
                                   class="btn btn-outline-secondary btn-sm px-2">
                                    Edit
                                </a>

                                <form action="{{ route('guru.mapel.destroy', $m->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Hapus mapel ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-dark btn-sm px-2">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4"
                                class="text-center text-muted py-5">
                                Belum ada mata pelajaran
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
