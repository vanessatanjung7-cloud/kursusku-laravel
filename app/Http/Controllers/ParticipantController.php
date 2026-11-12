<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\View\View;

class ParticipantController extends Controller
{
    public function index(): View
    {
        $participants = Participant::query()
            ->withCount('enrollments')
            ->orderBy('name')
            ->get();

        return view('participants.index', compact('participants'));
    }
}
