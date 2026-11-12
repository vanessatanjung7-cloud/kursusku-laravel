<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ParticipantController;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/pendaftaran', function () {
    $courses = Course::query()
        ->where('status', 'open')
        ->orderBy('name')
        ->get()
        ->mapWithKeys(fn (Course $course) => [$course->id => ['name' => $course->name]]);

    return view('registration.create', compact('courses'));
})->name('registration.create');

Route::post('/pendaftaran/preview', function (Request $request) {
    $data = $request->validate([
        'name'      => ['required', 'string', 'min:3', 'max:100'],
        'email'     => ['required', 'email'],
        'course_id' => ['required', 'integer'],
    ]);

    return back()
        ->with('success', 'Preview pendaftaran lolos validasi. Gunakan form enrollment untuk menyimpan pendaftaran.')
        ->withInput();
})->name('enrollments.preview');

Route::get('/courses/catalog', [CourseController::class, 'catalog'])
    ->name('courses.catalog');
Route::get('/courses/{course}/availability', [CourseController::class, 'availability'])
    ->name('courses.availability');

Route::resource('courses', CourseController::class);
Route::resource('participants', ParticipantController::class)->only(['index']);
Route::resource('enrollments', EnrollmentController::class)
    ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
