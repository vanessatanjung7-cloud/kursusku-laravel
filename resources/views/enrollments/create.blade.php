@extends('layouts.app')

@section('title', 'Tambah Enrollment - KursusKu')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                    <div>
                        <h1 class="h3 mb-1">Tambah Enrollment</h1>
                        <p class="text-secondary mb-0">Daftarkan peserta ke kursus yang masih dibuka.</p>
                    </div>
                    <a href="{{ route('enrollments.index') }}" class="btn btn-outline-secondary">Lihat Laporan</a>
                </div>

                @if ($participants->isEmpty())
                    <div class="alert alert-warning" role="status">
                        Belum ada data peserta. Jalankan <code>php artisan db:seed --class=ParticipantSeeder</code> terlebih dahulu.
                    </div>
                @endif
                @if ($courses->isEmpty())
                    <div class="alert alert-warning" role="status">Belum ada kursus dengan status open.</div>
                @endif

                <form method="POST" action="{{ route('enrollments.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="participant_id" class="form-label">Participant</label>
                        <select id="participant_id" name="participant_id"
                                class="form-select @error('participant_id') is-invalid @enderror" required>
                            <option value="">-- pilih peserta --</option>
                            @foreach ($participants as $participant)
                                <option value="{{ $participant->id }}" @selected(old('participant_id', $selectedParticipantId) == $participant->id)>
                                    {{ $participant->name }} ({{ $participant->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('participant_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="course_id" class="form-label">Course</label>
                        <select id="course_id" name="course_id"
                                class="form-select @error('course_id') is-invalid @enderror" required>
                            <option value="">-- pilih kursus --</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" @selected(old('course_id', $selectedCourseId) == $course->id)>
                                    {{ $course->name }} — mulai {{ $course->start_date->format('d M Y') }}
                                </option>
                            @endforeach
                        </select>
                        @error('course_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button class="btn btn-success" type="submit" @disabled($participants->isEmpty() || $courses->isEmpty())>
                        Simpan Enrollment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
