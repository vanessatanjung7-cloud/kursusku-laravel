<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Participant;
use Database\Seeders\ParticipantSeeder;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrollmentCrudTest extends TestCase
{
    use RefreshDatabase;

    private function course(array $overrides = []): Course
    {
        return Course::create(array_merge([
            'code' => 'KRS-001',
            'name' => 'Laravel Dasar',
            'description' => 'Belajar Laravel.',
            'fee' => 500000,
            'quota' => 20,
            'start_date' => '2027-01-15',
            'status' => 'open',
        ], $overrides));
    }

    private function participant(array $overrides = []): Participant
    {
        return Participant::create(array_merge([
            'name' => 'Alya Rahma',
            'email' => 'alya@example.test',
            'phone' => null,
        ], $overrides));
    }

    public function test_enrollment_report_shows_related_participant_course_date_and_status(): void
    {
        $participant = $this->participant();
        $course = $this->course();
        Enrollment::create(['participant_id' => $participant->id, 'course_id' => $course->id]);

        $this->get(route('enrollments.index'))
            ->assertOk()
            ->assertSee('Alya Rahma')
            ->assertSee('Laravel Dasar')
            ->assertSee('15 Jan 2027')
            ->assertSee('registered');
    }

    public function test_enrollment_report_has_empty_state_and_create_link(): void
    {
        $this->get(route('enrollments.index'))
            ->assertOk()
            ->assertSee('Belum ada enrollment')
            ->assertSee(route('enrollments.create'));
    }

    public function test_course_availability_api_counts_enrollments_from_database(): void
    {
        $participant = $this->participant();
        $course = $this->course(['quota' => 10]);
        Enrollment::create(['participant_id' => $participant->id, 'course_id' => $course->id]);

        $this->getJson(route('courses.availability', $course))
            ->assertOk()
            ->assertJson([
                'course' => 'Laravel Dasar',
                'remaining' => 9,
                'quota' => 10,
                'registered' => 1,
                'status' => 'open',
            ]);
    }

    public function test_create_page_lists_participants_and_only_open_courses_in_name_order(): void
    {
        $this->participant(['name' => 'Zara Peserta', 'email' => 'zara@example.test']);
        $this->participant(['name' => 'Alya Peserta', 'email' => 'alya2@example.test']);
        $this->course();
        $this->course(['code' => 'KRS-002', 'name' => 'PHP Dasar']);
        $this->course(['code' => 'KRS-003', 'name' => 'Kursus Draft', 'status' => 'draft']);

        $this->get(route('enrollments.create'))
            ->assertOk()
            ->assertSeeInOrder(['Alya Peserta', 'Zara Peserta'])
            ->assertSeeInOrder(['Laravel Dasar', 'PHP Dasar'])
            ->assertDontSee('Kursus Draft')
            ->assertSee('name="_token"', false);
    }

    public function test_valid_enrollment_is_saved_with_registered_status(): void
    {
        $participant = $this->participant();
        $course = $this->course();

        $this->post(route('enrollments.store'), [
            'participant_id' => $participant->id,
            'course_id' => $course->id,
        ])->assertRedirect(route('enrollments.index'))
            ->assertSessionHas('success', 'Enrollment berhasil disimpan.');

        $this->assertDatabaseHas('enrollments', [
            'participant_id' => $participant->id,
            'course_id' => $course->id,
            'status' => 'registered',
        ]);
    }

    public function test_missing_participant_is_rejected_and_old_course_input_is_preserved(): void
    {
        $course = $this->course();

        $this->from(route('enrollments.create'))
            ->post(route('enrollments.store'), ['course_id' => $course->id])
            ->assertRedirect(route('enrollments.create'))
            ->assertSessionHasErrors('participant_id')
            ->assertSessionHas('_old_input.course_id', (string) $course->id);

        $this->get(route('enrollments.create'))
            ->assertOk()
            ->assertSee('is-invalid', false)
            ->assertSee('Pilih peserta terlebih dahulu.');
    }

    public function test_unknown_participant_is_rejected(): void
    {
        $course = $this->course();
        $this->post(route('enrollments.store'), [
            'participant_id' => 999,
            'course_id' => $course->id,
        ])->assertSessionHasErrors('participant_id');
    }

    public function test_missing_course_is_rejected(): void
    {
        $participant = $this->participant();
        $this->post(route('enrollments.store'), [
            'participant_id' => $participant->id,
        ])->assertSessionHasErrors('course_id');
    }

    public function test_unknown_course_is_rejected(): void
    {
        $participant = $this->participant();
        $this->post(route('enrollments.store'), [
            'participant_id' => $participant->id,
            'course_id' => 999,
        ])->assertSessionHasErrors('course_id');
    }

    public function test_closed_course_cannot_be_enrolled(): void
    {
        $participant = $this->participant();
        $course = $this->course(['status' => 'closed']);
        $this->post(route('enrollments.store'), [
            'participant_id' => $participant->id,
            'course_id' => $course->id,
        ])->assertSessionHasErrors('course_id');

        $this->assertDatabaseCount('enrollments', 0);
    }

    public function test_duplicate_participant_course_pair_is_rejected_by_validation(): void
    {
        $participant = $this->participant();
        $course = $this->course();
        Enrollment::create(['participant_id' => $participant->id, 'course_id' => $course->id]);

        $this->post(route('enrollments.store'), [
            'participant_id' => $participant->id,
            'course_id' => $course->id,
        ])->assertSessionHasErrors('course_id');

        $this->assertDatabaseCount('enrollments', 1);
    }

    public function test_different_participants_can_enroll_in_same_course(): void
    {
        $course = $this->course();
        $alya = $this->participant();
        $bima = $this->participant(['name' => 'Bima Putra', 'email' => 'bima@example.test']);

        $this->post(route('enrollments.store'), ['participant_id' => $alya->id, 'course_id' => $course->id]);
        $this->post(route('enrollments.store'), ['participant_id' => $bima->id, 'course_id' => $course->id])
            ->assertRedirect(route('enrollments.index'));

        $this->assertDatabaseCount('enrollments', 2);
    }

    public function test_same_participant_can_enroll_in_different_courses(): void
    {
        $participant = $this->participant();
        $laravel = $this->course();
        $php = $this->course(['code' => 'KRS-002', 'name' => 'PHP Dasar']);

        $this->post(route('enrollments.store'), ['participant_id' => $participant->id, 'course_id' => $laravel->id]);
        $this->post(route('enrollments.store'), ['participant_id' => $participant->id, 'course_id' => $php->id])
            ->assertRedirect(route('enrollments.index'));

        $this->assertDatabaseCount('enrollments', 2);
    }

    public function test_required_alyas_bima_and_duplicate_enrollment_scenarios(): void
    {
        $alya = $this->participant();
        $bima = $this->participant(['name' => 'Bima Putra', 'email' => 'bima@example.test']);
        $laravel = $this->course();
        $php = $this->course(['code' => 'KRS-002', 'name' => 'PHP Dasar']);

        $this->post(route('enrollments.store'), ['participant_id' => $alya->id, 'course_id' => $laravel->id])
            ->assertRedirect(route('enrollments.index'));
        $this->post(route('enrollments.store'), ['participant_id' => $alya->id, 'course_id' => $laravel->id])
            ->assertSessionHasErrors('course_id');
        $this->post(route('enrollments.store'), ['participant_id' => $alya->id, 'course_id' => $php->id])
            ->assertRedirect(route('enrollments.index'));
        $this->post(route('enrollments.store'), ['participant_id' => $bima->id, 'course_id' => $laravel->id])
            ->assertRedirect(route('enrollments.index'));

        $this->assertDatabaseCount('enrollments', 3);
    }

    public function test_composite_unique_constraint_blocks_duplicate_rows_at_database_level(): void
    {
        $participant = $this->participant();
        $course = $this->course();
        Enrollment::create(['participant_id' => $participant->id, 'course_id' => $course->id]);

        $this->expectException(QueryException::class);
        Enrollment::create(['participant_id' => $participant->id, 'course_id' => $course->id]);
    }

    public function test_participant_and_course_many_to_many_relationship_includes_pivot_status_and_timestamps(): void
    {
        $participant = $this->participant();
        $course = $this->course();
        Enrollment::create(['participant_id' => $participant->id, 'course_id' => $course->id]);

        $this->assertSame($course->id, $participant->courses->first()->id);
        $this->assertSame('registered', $participant->courses->first()->pivot->status);
        $this->assertNotNull($participant->courses->first()->pivot->created_at);
        $this->assertSame($participant->id, $course->participants->first()->id);
        $this->assertCount(1, $participant->enrollments);
        $this->assertCount(1, $course->enrollments);
    }

    public function test_deleting_course_cascades_enrollments_but_keeps_participant(): void
    {
        $participant = $this->participant();
        $course = $this->course();
        $enrollment = Enrollment::create(['participant_id' => $participant->id, 'course_id' => $course->id]);

        $course->delete();

        $this->assertDatabaseMissing('enrollments', ['id' => $enrollment->id]);
        $this->assertDatabaseHas('participants', ['id' => $participant->id]);
    }

    public function test_deleting_participant_cascades_enrollments_but_keeps_course(): void
    {
        $participant = $this->participant();
        $course = $this->course();
        $enrollment = Enrollment::create(['participant_id' => $participant->id, 'course_id' => $course->id]);

        $participant->delete();

        $this->assertDatabaseMissing('enrollments', ['id' => $enrollment->id]);
        $this->assertDatabaseHas('courses', ['id' => $course->id]);
    }

    public function test_participant_seeder_is_idempotent(): void
    {
        $this->seed(ParticipantSeeder::class);
        $this->seed(ParticipantSeeder::class);

        $this->assertDatabaseCount('participants', 3);
        $this->assertDatabaseHas('participants', ['email' => 'alya@example.test']);
        $this->assertDatabaseHas('participants', ['email' => 'bima@example.test']);
        $this->assertDatabaseHas('participants', ['email' => 'citra@example.test']);
    }

    public function test_legacy_registration_form_route_remains_available(): void
    {
        $this->get(route('registration.create'))
            ->assertOk()
            ->assertSee('Pilih Kursus')
            ->assertSee(route('enrollments.create'));
    }
}
