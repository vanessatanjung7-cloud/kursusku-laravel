<?php

namespace Tests\Feature;

use App\Models\Course;
use Database\Seeders\CourseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseCrudTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'code' => 'CRS-001', 'name' => 'Laravel Dasar', 'description' => 'Kursus Laravel',
            'fee' => 250000, 'quota' => 25, 'start_date' => '2027-01-15', 'status' => 'open',
        ], $overrides);
    }

    private function course(array $overrides = []): Course
    {
        return Course::create($this->payload($overrides));
    }

    public function test_duplicate_code_on_create_is_rejected(): void
    {
        $this->course();
        $this->post(route('courses.store'), $this->payload())->assertSessionHasErrors('code');
    }

    public function test_valid_create_saves_course_and_flashes_success(): void
    {
        $this->post(route('courses.store'), $this->payload())
            ->assertRedirect(route('courses.index'))
            ->assertSessionHas('success', 'Kursus berhasil ditambahkan.');

        $this->assertDatabaseHas('courses', ['code' => 'CRS-001', 'name' => 'Laravel Dasar']);
    }

    public function test_empty_name_is_rejected(): void
    {
        $this->post(route('courses.store'), $this->payload(['name' => '']))->assertSessionHasErrors('name');
    }

    public function test_name_shorter_than_three_characters_is_rejected(): void
    {
        $this->post(route('courses.store'), $this->payload(['name' => 'AB']))->assertSessionHasErrors('name');
    }

    public function test_negative_fee_is_rejected(): void
    {
        $this->post(route('courses.store'), $this->payload(['fee' => -1]))->assertSessionHasErrors('fee');
    }

    public function test_non_integer_fee_is_rejected(): void
    {
        $this->post(route('courses.store'), $this->payload(['fee' => '250.5']))->assertSessionHasErrors('fee');
    }

    public function test_quota_zero_is_rejected(): void
    {
        $this->post(route('courses.store'), $this->payload(['quota' => 0]))->assertSessionHasErrors('quota');
    }

    public function test_quota_501_is_rejected(): void
    {
        $this->post(route('courses.store'), $this->payload(['quota' => 501]))->assertSessionHasErrors('quota');
    }

    public function test_quota_one_is_accepted(): void
    {
        $this->post(route('courses.store'), $this->payload(['quota' => 1]))->assertRedirect(route('courses.index'));
        $this->assertDatabaseHas('courses', ['code' => 'CRS-001', 'quota' => 1]);
    }

    public function test_quota_500_is_accepted(): void
    {
        $this->post(route('courses.store'), $this->payload(['quota' => 500]))->assertRedirect(route('courses.index'));
        $this->assertDatabaseHas('courses', ['code' => 'CRS-001', 'quota' => 500]);
    }

    public function test_invalid_date_is_rejected(): void
    {
        $this->post(route('courses.store'), $this->payload(['start_date' => 'not-a-date']))->assertSessionHasErrors('start_date');
    }

    public function test_unknown_status_is_rejected(): void
    {
        $this->post(route('courses.store'), $this->payload(['status' => 'archived']))->assertSessionHasErrors('status');
    }

    public function test_update_can_keep_its_own_code(): void
    {
        $course = $this->course();
        $this->put(route('courses.update', $course), $this->payload(['name' => 'Laravel Lanjutan']))
            ->assertRedirect(route('courses.show', $course))->assertSessionHasNoErrors();
        $this->assertDatabaseHas('courses', ['id' => $course->id, 'code' => 'CRS-001', 'name' => 'Laravel Lanjutan']);
    }

    public function test_update_cannot_use_another_courses_code(): void
    {
        $course = $this->course();
        $this->course(['code' => 'CRS-002', 'name' => 'PHP Dasar']);
        $this->put(route('courses.update', $course), $this->payload(['code' => 'CRS-002']))->assertSessionHasErrors('code');
    }

    public function test_valid_update_succeeds(): void
    {
        $course = $this->course();
        $this->put(route('courses.update', $course), $this->payload(['code' => 'CRS-NEW', 'name' => 'Laravel Mahir']))
            ->assertRedirect(route('courses.show', $course))->assertSessionHas('success');
        $this->assertDatabaseHas('courses', ['id' => $course->id, 'code' => 'CRS-NEW', 'name' => 'Laravel Mahir']);
    }

    public function test_delete_removes_course_and_redirects_to_index(): void
    {
        $course = $this->course();
        $this->delete(route('courses.destroy', $course))->assertRedirect(route('courses.index'))
            ->assertSessionHas('success', 'Kursus berhasil dihapus.');
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }

    public function test_index_show_and_edit_pages_render(): void
    {
        $course = $this->course();
        $this->get(route('courses.index'))->assertOk()->assertSee('Laravel Dasar')->assertSee('Tambah Kursus');
        $this->get(route('courses.show', $course))->assertOk()->assertSee('CRS-001')->assertSee('Kursus Laravel');
        $this->get(route('courses.edit', $course))->assertOk()->assertSee('Simpan Perubahan')->assertSee('2027-01-15');
    }

    public function test_missing_course_binding_returns_404(): void
    {
        $this->get('/courses/99999')->assertNotFound();
        $this->get('/courses/99999/edit')->assertNotFound();
    }

    public function test_forms_use_csrf_and_method_spoofing_for_update_and_delete(): void
    {
        $course = $this->course();
        $this->get(route('courses.edit', $course))->assertSee('name="_token"', false)->assertSee('name="_method"', false);
        $this->post(route('courses.update', $course), $this->payload(['_method' => 'PUT', 'name' => 'Laravel PUT']))
            ->assertRedirect(route('courses.show', $course));
        $this->post(route('courses.destroy', $course), ['_method' => 'DELETE'])->assertRedirect(route('courses.index'));
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }

    public function test_create_validation_errors_are_shown_beneath_invalid_fields(): void
    {
        $this->from(route('courses.create'))->post(route('courses.store'), $this->payload(['name' => '', 'fee' => -1]))
            ->assertRedirect(route('courses.create'));
        $this->get(route('courses.create'))->assertOk()->assertSee('is-invalid')->assertSee('The name field is required.');
    }

    public function test_each_course_field_has_validation_feedback(): void
    {
        $invalid = $this->payload([
            'code' => str_repeat('C', 21),
            'name' => 'AB',
            'description' => str_repeat('D', 2001),
            'fee' => '250.5',
            'quota' => 501,
            'start_date' => 'not-a-date',
            'status' => 'archived',
        ]);

        $this->from(route('courses.create'))->post(route('courses.store'), $invalid)
            ->assertRedirect(route('courses.create'))
            ->assertSessionHasErrors(['code', 'name', 'description', 'fee', 'quota', 'start_date', 'status']);

        $response = $this->get(route('courses.create'))->assertOk();
        $response->assertSee('name="code"', false)
            ->assertSee('name="name"', false)
            ->assertSee('name="description"', false)
            ->assertSee('name="fee"', false)
            ->assertSee('name="quota"', false)
            ->assertSee('name="start_date"', false)
            ->assertSee('name="status"', false);
        self::assertSame(7, substr_count($response->getContent(), 'is-invalid'));
    }

    public function test_course_seeder_creates_fifteen_complete_courses_idempotently(): void
    {
        $this->seed(CourseSeeder::class);
        $this->assertDatabaseCount('courses', 15);
        $this->assertSame(15, Course::query()
            ->whereNotNull('description')
            ->where('description', '<>', '')
            ->where('fee', '>=', 0)
            ->whereBetween('quota', [1, 500])
            ->whereNotNull('start_date')
            ->whereIn('status', ['draft', 'open', 'closed'])
            ->count());
        $this->assertDatabaseHas('courses', [
            'code' => 'KRS-001',
            'name' => 'Web Dasar',
            'fee' => 350000,
            'quota' => 30,
            'status' => 'open',
        ]);

        $this->seed(CourseSeeder::class);
        $this->assertDatabaseCount('courses', 15);
    }
}
