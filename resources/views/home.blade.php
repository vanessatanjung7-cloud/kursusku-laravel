@extends('layouts.app')

@section('title', 'Beranda - KursusKu')

@section('content')
<section class="hero mb-5">
    <div class="row align-items-center">
        <div class="col-lg-9">
            <span class="badge text-bg-success mb-3">Kursus teknologi untuk mahasiswa</span>
            <h1 class="display-5 fw-bold">Belajar lebih terarah bersama KursusKu</h1>
            <p class="lead text-secondary">Jelajahi kursus yang tersedia, lihat detailnya, lalu daftarkan peserta dengan mudah.</p>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('courses.catalog') }}" class="btn btn-success btn-lg px-4">Daftar Kursus</a>
                <a href="{{ route('enrollments.create') }}" class="btn btn-outline-success btn-lg px-4">Tambah Enrollment</a>
            </div>
        </div>
    </div>
</section>

<section class="mb-5" aria-label="Ringkasan KursusKu">
    <div class="row g-3">
        <div class="col-6 col-lg-3"><div class="card feature-card h-100"><div class="card-body"><div class="text-secondary small">Semua kursus</div><div class="h3 mb-0">{{ $stats['courses'] }}</div></div></div></div>
        <div class="col-6 col-lg-3"><div class="card feature-card h-100"><div class="card-body"><div class="text-secondary small">Kursus dibuka</div><div class="h3 mb-0">{{ $stats['open_courses'] }}</div></div></div></div>
        <div class="col-6 col-lg-3"><div class="card feature-card h-100"><div class="card-body"><div class="text-secondary small">Peserta</div><div class="h3 mb-0">{{ $stats['participants'] }}</div></div></div></div>
        <div class="col-6 col-lg-3"><div class="card feature-card h-100"><div class="card-body"><div class="text-secondary small">Enrollment</div><div class="h3 mb-0">{{ $stats['enrollments'] }}</div></div></div></div>
    </div>
</section>

<section>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div><h2 class="h4 fw-bold mb-1">Kursus yang segera dimulai</h2><p class="text-secondary mb-0">Pilihan kursus yang sedang dibuka.</p></div>
        <a href="{{ route('courses.catalog') }}" class="btn btn-outline-success">Lihat semua kursus</a>
    </div>
    <div class="row g-4">
        @forelse ($featured as $course)
            <div class="col-md-6 col-xl-4">
                <article class="card feature-card h-100">
                    <div class="card-body d-flex flex-column">
                        <span class="badge text-bg-success align-self-start mb-3">Pendaftaran dibuka</span>
                        <h3 class="h5">{{ $course->name }}</h3>
                        <p class="text-secondary flex-grow-1">{{ \Illuminate\Support\Str::limit($course->description, 115) }}</p>
                        <div class="small text-secondary mb-3">Mulai {{ $course->start_date->format('d M Y') }} · {{ $course->quota }} kursi</div>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('courses.show', $course) }}" class="btn btn-outline-primary">Lihat Detail</a>
                            <a href="{{ route('enrollments.create', ['course_id' => $course->id]) }}" class="btn btn-success">Daftarkan Peserta</a>
                        </div>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info mb-0">Belum ada kursus yang dibuka. Silakan kembali lagi nanti.</div></div>
        @endforelse
    </div>
</section>
@endsection
