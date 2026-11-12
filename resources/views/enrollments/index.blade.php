@extends('layouts.app')

@section('title', 'Laporan Enrollment - KursusKu')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="h2 mb-1">Laporan Enrollment</h1>
        <p class="text-secondary mb-0">Daftar relasi peserta dan kursus.</p>
    </div>
    <a href="{{ route('enrollments.create') }}" class="btn btn-success">Tambah Enrollment</a>
</div>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col">Nomor</th>
                    <th scope="col">Nama Participant</th>
                    <th scope="col">Nama Course</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">Status Enrollment</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($enrollments as $enrollment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $enrollment->participant->name }}</td>
                        <td>{{ $enrollment->course->name }}</td>
                        <td>{{ $enrollment->course->start_date->format('d M Y') }}</td>
                        <td><span class="badge text-bg-success">{{ $enrollment->status }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-secondary py-5">
                            Belum ada enrollment. <a href="{{ route('enrollments.create') }}">Tambah enrollment pertama</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
