<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Participant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EnrollmentController extends Controller
{
    public function index(): View
    {
        $enrollments = Enrollment::with(['participant', 'course'])
            ->latest()
            ->get();

        return view('enrollments.index', compact('enrollments'));
    }

    public function create(): View
    {
        $participants = Participant::query()->orderBy('name')->get();
        // Pertemuan 11 uses `open` for courses that are available for enrollment.
        $courses = Course::query()->where('status', 'open')->orderBy('name')->get();

        return view('enrollments.create', compact('participants', 'courses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'participant_id' => ['required', 'integer', 'exists:participants,id'],
            'course_id' => [
                'required',
                'integer',
                Rule::exists('courses', 'id')->where('status', 'open'),
                Rule::unique('enrollments', 'course_id')->where(
                    fn ($query) => $query->where('participant_id', $request->input('participant_id')),
                ),
            ],
        ], [
            'participant_id.required' => 'Pilih peserta terlebih dahulu.',
            'participant_id.exists' => 'Peserta yang dipilih tidak tersedia.',
            'course_id.required' => 'Pilih kursus terlebih dahulu.',
            'course_id.exists' => 'Kursus tidak tersedia atau pendaftarannya sudah ditutup.',
            'course_id.unique' => 'Peserta tersebut sudah terdaftar pada kursus ini.',
        ]);

        $data['status'] = 'registered';
        Enrollment::create($data);

        return to_route('enrollments.index')
            ->with('success', 'Enrollment berhasil disimpan.');
    }
}
