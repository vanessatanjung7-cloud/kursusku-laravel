<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NavigationTest extends TestCase
{
    use RefreshDatabase;

    private function course(array $overrides = []): Course
    {
        return Course::create(array_merge([
            'code' => 'NAV-001',
            'name' => 'Laravel Dasar',
            'description' => 'Belajar Laravel dari dasar.',
            'fee' => 500000,
            'quota' => 20,
            'start_date' => '2027-01-15',
            'status' => 'open',
        ], $overrides));
    }

    public function test_home_daftar_kursus_button_and_main_menu_have_distinct_destinations(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('navbar-expand-xl', false)
            ->assertSee('data-bs-target="#mainNavbar"', false)
            ->assertSee('Daftar Kursus')
            ->assertSee('href="'.route('courses.catalog').'"', false)
            ->assertSee('href="'.route('courses.index').'"', false)
            ->assertSee('Kelola Kursus')
            ->assertSee('href="'.route('courses.create').'"', false)
            ->assertSee('Tambah Kursus')
            ->assertSee('href="'.route('participants.index').'"', false)
            ->assertSee('Peserta')
            ->assertSee('href="'.route('enrollments.create').'"', false)
            ->assertSee('Tambah Enrollment')
            ->assertSee('href="'.route('enrollments.index').'"', false)
            ->assertSee('Kelola Enrollment');
    }

    public function test_home_featured_courses_are_real_open_database_courses(): void
    {
        $this->course();
        $this->course(['code' => 'NAV-002', 'name' => 'Kursus Draft', 'status' => 'draft']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Laravel Dasar')
            ->assertSee(route('courses.show', Course::where('code', 'NAV-001')->first()), false)
            ->assertDontSee('Kursus Draft');
    }

    public function test_catalog_lists_open_courses_and_separates_detail_and_enrollment_actions(): void
    {
        $open = $this->course();
        $this->course(['code' => 'NAV-002', 'name' => 'Kursus Ditutup', 'status' => 'closed']);

        $this->get(route('courses.catalog'))
            ->assertOk()
            ->assertSee('Laravel Dasar')
            ->assertDontSee('Kursus Ditutup')
            ->assertSee('href="'.route('courses.show', $open).'"', false)
            ->assertSee('href="'.route('enrollments.create', ['course_id' => $open->id]).'"', false);
    }

    public function test_course_results_partial_returns_only_the_search_result_fragment(): void
    {
        $this->course();

        $this->get(route('courses.index', ['partial' => 1]))
            ->assertOk()
            ->assertSee('Laravel Dasar')
            ->assertDontSee('navbar-brand');
    }

    public function test_course_detail_and_participant_actions_preselect_the_correct_enrollment_data(): void
    {
        $course = $this->course();
        $participant = Participant::create([
            'name' => 'Alya Rahma',
            'email' => 'alya@example.test',
            'phone' => null,
        ]);

        $this->get(route('courses.show', $course))
            ->assertOk()
            ->assertSee('href="'.route('enrollments.create', ['course_id' => $course->id]).'"', false);

        $this->get(route('participants.index'))
            ->assertOk()
            ->assertSee('Alya Rahma')
            ->assertSee('href="'.route('enrollments.create', ['participant_id' => $participant->id]).'"', false);

        $response = $this->get(route('enrollments.create', ['participant_id' => $participant->id, 'course_id' => $course->id]))
            ->assertOk()
            ->assertSee('value="'.$participant->id.'" selected', false);

        preg_match('/<select id="course_id".*?<\/select>/s', $response->getContent(), $courseSelect);
        $this->assertNotEmpty($courseSelect);
        $this->assertStringContainsString('value="'.$course->id.'" selected', $courseSelect[0]);
    }

    public function test_catalog_management_participants_and_enrollment_pages_all_render(): void
    {
        $course = $this->course();
        $participant = Participant::create(['name' => 'Alya Rahma', 'email' => 'alya@example.test']);
        $enrollment = Enrollment::create(['participant_id' => $participant->id, 'course_id' => $course->id]);

        foreach ([
            route('home'),
            route('courses.catalog'),
            route('courses.index'),
            route('courses.create'),
            route('courses.show', 1),
            route('courses.edit', 1),
            route('participants.index'),
            route('enrollments.create'),
            route('enrollments.index'),
            route('enrollments.show', $enrollment),
            route('enrollments.edit', $enrollment),
        ] as $url) {
            $this->get($url)->assertOk();
        }
    }
}
