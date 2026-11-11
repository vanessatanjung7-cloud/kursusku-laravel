@extends('layouts.app')
@section('title', 'Tambah Kursus - KursusKu')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><div><p class="text-success fw-semibold mb-1">MANAJEMEN KURSUS</p><h1 class="h2 mb-0">Tambah Kursus</h1></div><a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">Kembali</a></div>
<form action="{{ route('courses.store') }}" method="POST" class="card card-body shadow-sm p-4">@csrf @include('courses._form')<div class="d-flex gap-2 mt-4"><button class="btn btn-success">Simpan Kursus</button><a href="{{ route('courses.index') }}" class="btn btn-light">Batal</a></div></form>
@endsection
