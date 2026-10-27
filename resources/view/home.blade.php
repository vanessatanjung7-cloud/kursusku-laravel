@extends('layouts.app')

@section('title', 'Beranda - KursusKu')

@section('content')
<section class="hero mb-5">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <span class="badge text-bg-success mb-3">
                Kursus teknologi untuk mahasiswa
            </span>

            <h1 class="display-5 fw-bold">
                Belajar lebih terarah bersama KursusKu
            </h1>

            <p class="lead text-secondary">
                Pilih kursus, cek ketersediaan kursi, lalu isi formulir pendaftaran.
            </p>

            <a href="{{ route('enrollments.create') }}"
               class="btn btn-success btn-lg px-4">
                Daftar Kursus
            </a>
        </div>
    </div>
</section>

<section>
    <h2 class="h4 fw-bold mb-4">Kursus Tersedia</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card feature-card h-100">
                <div class="card-body">
                    <h3 class="h5">Web Dasar</h3>
                    <p class="text-secondary mb-0">
                        Mengenal HTML, CSS, dan dasar-dasar membangun halaman web.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature-card h-100">
                <div class="card-body">
                    <h3 class="h5">PHP Dasar</h3>
                    <p class="text-secondary mb-0">
                        Logika pemrograman sisi server dengan PHP.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature-card h-100">
                <div class="card-body">
                    <h3 class="h5">Laravel Dasar</h3>
                    <p class="text-secondary mb-0">
                        Route, Blade, dan struktur aplikasi dengan Laravel.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection