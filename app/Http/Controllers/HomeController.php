<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Participant;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featured = Course::query()
            ->where('status', 'open')
            ->orderBy('start_date')
            ->limit(6)
            ->get();

        $stats = [
            'courses' => Course::count(),
            'open_courses' => Course::where('status', 'open')->count(),
            'participants' => Participant::count(),
            'enrollments' => Enrollment::count(),
        ];

        return view('home', compact('featured', 'stats'));
    }
}