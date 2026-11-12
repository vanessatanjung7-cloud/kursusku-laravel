<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Models\Course;

Route::get('/', function () {
    return view('home');
})->name('home');

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
        ->with('success', 'Form lolos validasi. Database akan ditambahkan pada pertemuan berikutnya.')
        ->withInput();
})->name('enrollments.preview');

Route::get('/courses/{course}/availability', [CourseController::class, 'availability'])
    ->name('courses.availability');

Route::resource('courses', CourseController::class);
Route::resource('enrollments', EnrollmentController::class)
    ->only(['index', 'create', 'store']);
