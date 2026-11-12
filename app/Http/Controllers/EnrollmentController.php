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

    public function show(Enrollment $enrollment): View
    {
        $enrollment->load(['participant', 'course']);

        return view('enrollments.show', compact('enrollment'));
    }

    public function edit(Enrollment $enrollment): View
    {
        $enrollment->load(['participant', 'course']);
        $participants = Participant::query()->orderBy('name')->get();
        $courses = Course::query()
            ->where(function ($query) use ($enrollment) {
                $query->where('status', 'open')->orWhere('id', $enrollment->course_id);
            })
            ->orderBy('name')
            ->get();

        return view('enrollments.edit', compact('enrollment', 'participants', 'courses'));
    }

    public function create(Request $request): View
    {
        $participants = Participant::query()->orderBy('name')->get();
        // Pertemuan 11 uses `open` for courses that are available for enrollment.
        $courses = Course::query()->where('status', 'open')->orderBy('name')->get();
        $selectedParticipantId = $request->integer('participant_id');
        $selectedCourseId = $request->integer('course_id');

        return view('enrollments.create', compact('participants', 'courses', 'selectedParticipantId', 'selectedCourseId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        $data['status'] = 'registered';
        Enrollment::create($data);

        return to_route('enrollments.index')
            ->with('success', 'Enrollment berhasil disimpan.');
    }

    public function update(Request $request, Enrollment $enrollment): RedirectResponse
    {
        $data = $this->validatedData($request, $enrollment);
        $data['status'] = $request->validate([
            'status' => ['required', Rule::in(['registered', 'completed', 'cancelled'])],
        ])['status'];

        $enrollment->update($data);

        return to_route('enrollments.show', $enrollment)
            ->with('success', 'Enrollment berhasil diperbarui.');
    }

    public function destroy(Enrollment $enrollment): RedirectResponse
    {
        $enrollment->delete();

        return to_route('enrollments.index')
            ->with('success', 'Enrollment berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Enrollment $enrollment = null): array
    {
        return $request->validate([
            'participant_id' => ['required', 'integer', 'exists:participants,id'],
            'course_id' => [
                'required',
                'integer',
                Rule::exists('courses', 'id')->where(function ($query) use ($enrollment) {
                    $query->where('status', 'open');

                    if ($enrollment) {
                        $query->orWhere('id', $enrollment->course_id);
                    }
                }),
                Rule::unique('enrollments', 'course_id')
                    ->where(fn ($query) => $query->where('participant_id', $request->input('participant_id')))
                    ->ignore($enrollment),
            ],
        ], [
            'participant_id.required' => 'Pilih peserta terlebih dahulu.',
            'participant_id.exists' => 'Peserta yang dipilih tidak tersedia.',
            'course_id.required' => 'Pilih kursus terlebih dahulu.',
            'course_id.exists' => 'Kursus tidak tersedia atau pendaftarannya sudah ditutup.',
            'course_id.unique' => 'Peserta tersebut sudah terdaftar pada kursus ini.',
        ]);
    }
}
