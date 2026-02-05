@extends('layouts.guru')

@section('content')
<div class="container-fluid mt-4">

    {{-- TITLE + FILTER + BACK --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <div>
            <h4 class="fw-bold mb-1">Pengumpulan Tugas</h4>
            <small class="text-muted">{{ $tugas->judul }}</small>
        </div>

        {{-- KANAN: FILTER + BACK --}}
        <div class="d-flex align-items-center gap-2">
            <select id="filterNilai" class="form-select form-select-sm w-auto">
                <option value="all">Semua</option>
                <option value="belum">Belum Dinilai</option>
                <option value="sudah">Sudah Dinilai</option>
            </select>

            <a href="{{ url()->previous() }}"
               class="btn btn-outline-secondary btn-sm">
                ← Kembali
            </a>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-uppercase small text-muted">
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Catatan</th>
                        <th>File</th>
                        <th>Status</th>
                        <th width="20%">Nilai</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($tugas->pengumpulan as $p)
                    <tr data-nilai="{{ $p->nilai === null ? 'belum' : 'sudah' }}">
                        <td class="fw-semibold">
                            {{ $p->siswa->name ?? '-' }}
                        </td>

                        <td class="text-muted">
                            {{ $p->catatan ?: '-' }}
                        </td>

                        <td>
                            @if($p->file)
                                <a href="{{ asset('storage/'.$p->file) }}"
                                   target="_blank"
                                   class="btn btn-outline-dark btn-sm px-3">
                                    Lihat
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td>
                            <span class="badge bg-light text-dark border">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>

                        <td>
                            @if($p->nilai === null)
                                <form action="{{ route('guru.tugas.nilai', $p->id) }}"
                                      method="POST"
                                      class="d-flex gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="number"
                                           name="nilai"
                                           min="0"
                                           max="100"
                                           class="form-control form-control-sm"
                                           placeholder="0–100"
                                           required>
                                    <button class="btn btn-dark btn-sm px-3">
                                        Simpan
                                    </button>
                                </form>
                            @else
                                <span class="fw-semibold text-dark">
                                    {{ $p->nilai }}
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            Belum ada pengumpulan
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- JAVASCRIPT FILTER --}}
<script>
document.getElementById('filterNilai').addEventListener('change', function () {
    const filter = this.value;
    const rows = document.querySelectorAll('tbody tr[data-nilai]');

    rows.forEach(row => {
        if (filter === 'all') {
            row.style.display = '';
        } else {
            row.style.display = row.dataset.nilai === filter ? '' : 'none';
        }
    });
});
</script>
@endsection
