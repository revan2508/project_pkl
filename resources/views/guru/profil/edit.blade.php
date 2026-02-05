@extends('layouts.guru')

@section('content')
<div class="container">
    <h4>Profil Guru</h4>

    <div class="card mt-3">
        <div class="card-body">
            <div class="mb-3">
                <strong>Nama:</strong> {{ Auth::user()->name }}
            </div>
            <div class="mb-3">
                <strong>Email:</strong> {{ Auth::user()->email }}
            </div>
            <div class="mb-3">
                <strong>NIP:</strong> {{ $guru->nip ?? '-' }}
            </div>
            <div class="mb-3">
                <strong>Mata Pelajaran:</strong> {{ $guru->mapel ?? '-' }}
            </div>
            <div class="mb-3">
                <strong>Foto:</strong><br>
                @
            </div>
            <a href="{{ route('guru.profil.edit') }}" class="btn btn-sm btn-primary">Edit Profil</a>
        </div>
    </div>
</div>
@endsection
