@extends('layouts.app')

@section('title', 'Detail Enrollment - KursusKu')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div><p class="text-success fw-semibold mb-1">DETAIL PENDAFTARAN</p><h1 class="h2 mb-0">Enrollment #{{ $enrollment->id }}</h1></div>
    <div class="d-flex gap-2"><a href="{{ route('enrollments.index') }}" class="btn btn-outline-secondary">Kembali ke daftar</a><a href="{{ route('enrollments.edit', $enrollment) }}" class="btn btn-success">Edit Enrollment</a></div>
</div>
<div class="card shadow-sm border-0"><div class="card-body p-4">
    <dl class="row mb-0">
        <dt class="col-sm-3">Peserta</dt><dd class="col-sm-9">{{ $enrollment->participant->name }} ({{ $enrollment->participant->email }})</dd>
        <dt class="col-sm-3">Kursus</dt><dd class="col-sm-9">{{ $enrollment->course->name }} ({{ $enrollment->course->code }})</dd>
        <dt class="col-sm-3">Tanggal mulai</dt><dd class="col-sm-9">{{ $enrollment->course->start_date->format('d M Y') }}</dd>
        <dt class="col-sm-3">Biaya kursus</dt><dd class="col-sm-9">Rp {{ number_format($enrollment->course->fee, 0, ',', '.') }}</dd>
        <dt class="col-sm-3">Status</dt><dd class="col-sm-9">{{ ucfirst($enrollment->status) }}</dd>
        <dt class="col-sm-3">Dibuat</dt><dd class="col-sm-9">{{ $enrollment->created_at->format('d M Y H:i') }}</dd>
    </dl>
</div></div>
@endsection
