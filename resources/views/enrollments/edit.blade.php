@extends('layouts.app')

@section('title', 'Edit Enrollment - KursusKu')

@section('content')
<div class="row justify-content-center"><div class="col-lg-8"><div class="card shadow-sm border-0"><div class="card-body p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4"><div><h1 class="h3 mb-1">Edit Enrollment #{{ $enrollment->id }}</h1><p class="text-secondary mb-0">Perbarui peserta, kursus, atau status pendaftaran.</p></div><a href="{{ route('enrollments.show', $enrollment) }}" class="btn btn-outline-secondary">Kembali ke detail</a></div>
    <form method="POST" action="{{ route('enrollments.update', $enrollment) }}">
        @csrf @method('PUT')
        <div class="mb-3"><label for="participant_id" class="form-label">Peserta</label><select id="participant_id" name="participant_id" class="form-select @error('participant_id') is-invalid @enderror" required><option value="">-- pilih peserta --</option>@foreach ($participants as $participant)<option value="{{ $participant->id }}" @selected(old('participant_id', $enrollment->participant_id) == $participant->id)>{{ $participant->name }} ({{ $participant->email }})</option>@endforeach</select>@error('participant_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-3"><label for="course_id" class="form-label">Kursus</label><select id="course_id" name="course_id" class="form-select @error('course_id') is-invalid @enderror" required><option value="">-- pilih kursus --</option>@foreach ($courses as $course)<option value="{{ $course->id }}" @selected(old('course_id', $enrollment->course_id) == $course->id)>{{ $course->name }} — mulai {{ $course->start_date->format('d M Y') }}</option>@endforeach</select>@error('course_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-4"><label for="status" class="form-label">Status enrollment</label><select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>@foreach (['registered' => 'Terdaftar', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $value => $label)<option value="{{ $value }}" @selected(old('status', $enrollment->status) === $value)>{{ $label }}</option>@endforeach</select>@error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <button class="btn btn-success" type="submit">Simpan Perubahan</button> <a href="{{ route('enrollments.show', $enrollment) }}" class="btn btn-light">Batal</a>
    </form>
</div></div></div></div>
@endsection
