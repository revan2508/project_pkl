@extends('layouts.siswa')

@section('content')
<div class="container">
    <h4>Profil Siswa</h4>

    <div class="card mt-3">
        <div class="card-body">
            <div class="mb-3">
                <strong>Nama:</strong> {{ Auth::user()->name }}
            </div>
            <div class="mb-3">
                <strong>Email:</strong> {{ Auth::user()->email }}
            </div>
            <div class="mb-3">
                <strong>NIS:</strong> {{ $siswa->nis ?? '-' }}
            </div>
            <div class="mb-3">
                <strong>Kelas:</strong> {{ $siswa->kelas ?? '-' }}
            </div>
            <div class="mb-3">
                <strong>Alamat:</strong> {{ $siswa->alamat ?? '-' }}
            </div>
            <div class="mb-3">
                <strong>Foto:</strong><br>
                @if ($siswa->foto)
                    <img src="{{ asset('storage/' . $siswa->foto) }}" width="150" class="img-thumbnail">
                @else
                    <em>Belum ada foto</em>
                @endif
            </div>
            <a href="{{ route('siswa.profil.edit') }}" class="btn btn-sm btn-primary">Edit Profil</a>
        </div>
    </div>
</div>
@endsection
