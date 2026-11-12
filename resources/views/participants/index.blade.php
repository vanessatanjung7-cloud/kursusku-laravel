@extends('layouts.app')

@section('title', 'Peserta - KursusKu')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
    <div>
        <p class="text-success fw-semibold mb-1">DATA PESERTA</p>
        <h1 class="h2 mb-1">Peserta</h1>
        <p class="text-secondary mb-0">Daftar peserta dan jumlah enrollment mereka.</p>
    </div>
    <a href="{{ route('enrollments.create') }}" class="btn btn-success">Tambah Enrollment</a>
</div>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Nama</th><th>Email</th><th>Telepon</th><th>Jumlah Enrollment</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse ($participants as $participant)
                    <tr>
                        <td class="fw-semibold">{{ $participant->name }}</td>
                        <td>{{ $participant->email }}</td>
                        <td>{{ $participant->phone ?: '—' }}</td>
                        <td>{{ $participant->enrollments_count }}</td>
                        <td><a href="{{ route('enrollments.create', ['participant_id' => $participant->id]) }}" class="btn btn-sm btn-outline-success">Daftarkan ke Kursus</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-secondary py-5">Belum ada peserta. Jalankan seeder peserta atau tambahkan dari database.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
