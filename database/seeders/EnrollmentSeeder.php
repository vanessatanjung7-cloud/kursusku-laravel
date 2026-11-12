<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Participant;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $participants = Participant::query()->whereIn('email', [
            'alya@example.test',
            'bima@example.test',
            'citra@example.test',
        ])->get()->keyBy('email');

        $courses = Course::query()->whereIn('code', [
            'KRS-001', 'KRS-002', 'KRS-003', 'KRS-004', 'KRS-005',
        ])->get()->keyBy('code');

        $pairs = [
            ['alya@example.test', 'KRS-001'],
            ['alya@example.test', 'KRS-002'],
            ['alya@example.test', 'KRS-003'],
            ['alya@example.test', 'KRS-004'],
            ['alya@example.test', 'KRS-005'],
            ['bima@example.test', 'KRS-001'],
            ['bima@example.test', 'KRS-002'],
            ['bima@example.test', 'KRS-003'],
            ['bima@example.test', 'KRS-004'],
            ['bima@example.test', 'KRS-005'],
            ['citra@example.test', 'KRS-001'],
            ['citra@example.test', 'KRS-002'],
            ['citra@example.test', 'KRS-003'],
            ['citra@example.test', 'KRS-004'],
            ['citra@example.test', 'KRS-005'],
        ];

        foreach ($pairs as [$email, $courseCode]) {
            $participant = $participants->get($email);
            $course = $courses->get($courseCode);

            if (! $participant || ! $course) {
                continue;
            }

            Enrollment::firstOrCreate(
                ['participant_id' => $participant->id, 'course_id' => $course->id],
                ['status' => 'registered'],
            );
        }
    }
}
