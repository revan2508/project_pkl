@extends('layouts.backend')

@section('content')
<div class="container-fluid">

    <!-- Owl carousel -->
    <div class="owl-carousel counter-carousel owl-theme">

        <!-- TOTAL USERS -->
        <div class="item">
            <div class="card border-0 zoom-in bg-primary-subtle shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('assets/backend/images/svgs/icon-user-male.svg') }}"
                             width="50" height="50"
                             class="mb-3"
                             alt="Users" />
                        <p class="fw-semibold fs-3 text-primary mb-1">
                            Total Users
                        </p>
                        <h5 class="fw-semibold text-primary mb-0">
                            {{ $userCount }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- TOTAL GURU -->
        <div class="item">
            <div class="card border-0 zoom-in bg-warning-subtle shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('assets/backend/images/svgs/icon-briefcase.svg') }}"
                             width="50" height="50"
                             class="mb-3"
                             alt="Guru" />
                        <p class="fw-semibold fs-3 text-warning mb-1">
                            Guru
                        </p>
                        <h5 class="fw-semibold text-warning mb-0">
                            {{ $guruCount }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- TOTAL SISWA -->
        <div class="item">
            <div class="card border-0 zoom-in bg-success-subtle shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('assets/backend/images/svgs/icon-user-male.svg') }}"
                             width="50" height="50"
                             class="mb-3"
                             alt="Siswa" />
                        <p class="fw-semibold fs-3 text-success mb-1">
                            Siswa
                        </p>
                        <h5 class="fw-semibold text-success mb-0">
                            {{ $siswaCount }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
