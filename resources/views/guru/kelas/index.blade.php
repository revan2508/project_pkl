@extends('layouts.guru')

@section('content')
<div class="container-fluid mt-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Daftar Kelas</h4>
            <small class="text-muted">Kelola kelas yang kamu ajar</small>
        </div>
        <a href="{{ route('guru.kelas.create') }}"
           class="btn btn-dark btn-sm px-3">
            + Tambah Kelas
        </a>
    </div>

    {{-- INFO BAR --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body py-3 d-flex justify-content-between align-items-center">
            <span class="text-muted small">
                Total Kelas: <strong class="text-dark">{{ $kelas->count() }}</strong>
            </span>
            <span class="text-muted small">
                {{ now()->format('d M Y') }}
            </span>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-uppercase small text-muted">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Kelas</th>
                        <th class="text-center">Mapel</th>
                        <th class="text-center">Kode</th>
                        <th class="text-center" width="18%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kelas as $k)
                        <tr>
                            <td class="text-muted">{{ $loop->iteration }}</td>

                            <td class="fw-semibold">
                                {{ $k->nama_kelas }}
                            </td>

                            <td class="text-center">
                                <span class="badge bg-light text-dark border">
                                    {{ $k->mapel_count }} Mapel
                                </span>
                            </td>

                            {{-- KODE + COPY --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <code id="kode-{{ $k->id }}" class="text-dark fw-semibold">
                                        {{ $k->kode_kelas }}
                                    </code>

                                    <button
                                        class="btn btn-outline-secondary btn-sm"
                                        onclick="copyKode('{{ $k->id }}')"
                                        title="Copy kode kelas">
                                        COPY
                                    </button>
                                </div>
                            </td>

                            <td class="text-center">
                                <a href="{{ route('guru.kelas.mapel.create', $k) }}"
                                   class="btn btn-outline-dark btn-sm px-2">
                                    Mapel
                                </a>
                                <a href="{{ route('guru.kelas.edit', $k) }}"
                                   class="btn btn-outline-secondary btn-sm px-2">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                Belum ada kelas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- SCRIPT COPY --}}
<script>
    function copyKode(id) {
        const text = document.getElementById('kode-' + id).innerText;

        navigator.clipboard.writeText(text).then(() => {
            alert('Kode kelas berhasil disalin: ' + text);
        }).catch(() => {
            alert('Gagal menyalin kode');
        });
    }
</script>
@endsection
