@extends('layouts.app')

@section('title', 'Daftar Kursus - KursusKu')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
    <div>
        <p class="text-success fw-semibold mb-1">KATALOG KURSUS</p>
        <h1 class="h2 mb-1">Daftar Kursus</h1>
        <p class="text-secondary mb-0">Pilih kursus yang sedang membuka pendaftaran.</p>
    </div>
    <a href="{{ route('home') }}" class="btn btn-outline-secondary">Kembali ke Beranda</a>
</div>

<div class="row g-4">
    @forelse ($courses as $course)
        <div class="col-md-6 col-xl-4">
            <article class="card feature-card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between gap-3 mb-3">
                        <span class="badge text-bg-success">Pendaftaran dibuka</span>
                        <span class="small text-secondary">{{ $course->code }}</span>
                    </div>
                    <h2 class="h5">{{ $course->name }}</h2>
                    <p class="text-secondary flex-grow-1">{{ \Illuminate\Support\Str::limit($course->description ?: 'Informasi kursus akan segera tersedia.', 150) }}</p>
                    <dl class="row small mb-3">
                        <dt class="col-6 text-secondary">Mulai</dt><dd class="col-6 text-end">{{ $course->start_date->format('d M Y') }}</dd>
                        <dt class="col-6 text-secondary">Biaya</dt><dd class="col-6 text-end">Rp {{ number_format($course->fee, 0, ',', '.') }}</dd>
                        <dt class="col-6 text-secondary">Kuota</dt><dd class="col-6 text-end">{{ $course->quota }} peserta</dd>
                    </dl>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('courses.show', $course) }}" class="btn btn-outline-primary">Lihat Detail</a>
                        <a href="{{ route('enrollments.create', ['course_id' => $course->id]) }}" class="btn btn-success">Daftarkan Peserta</a>
                    </div>
                </div>
            </article>
        </div>
    @empty
        <div class="col-12"><div class="alert alert-info">Belum ada kursus yang membuka pendaftaran saat ini.</div></div>
    @endforelse
</div>
@endsection
