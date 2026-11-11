@extends('layouts.app')
@section('title', 'Edit '.$course->name.' - KursusKu')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><div><p class="text-success fw-semibold mb-1">MANAJEMEN KURSUS</p><h1 class="h2 mb-0">Edit Kursus</h1></div><a href="{{ route('courses.show', $course) }}" class="btn btn-outline-secondary">Kembali ke detail</a></div>
<form action="{{ route('courses.update', $course) }}" method="POST" class="card card-body shadow-sm p-4">@csrf @method('PUT') @include('courses._form', ['course' => $course])<div class="d-flex gap-2 mt-4"><button class="btn btn-success">Simpan Perubahan</button><a href="{{ route('courses.show', $course) }}" class="btn btn-light">Batal</a></div></form>
@endsection
