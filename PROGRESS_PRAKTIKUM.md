# Progress Praktikum Pertemuan 11

Pembaruan terakhir: 11 November 2026

**Legenda:** `[x]` selesai dan diverifikasi, `[ ]` belum selesai, `[!]` perlu pemeriksaan/tindakan manual.

## Checklist pekerjaan

| Status | Pekerjaan | File dan pekerjaan | Verifikasi / catatan |
|---|---|---|---|
| [x] | Pemeriksaan struktur project | Struktur Laravel, routes, app, database, resources, tests | Teridentifikasi Laravel 12; file `artisan` awal berisi README dan dipulihkan. |
| [x] | Pemeriksaan Laravel dan database | `composer.json`, `.env`, `phpunit.xml`, `database/database.sqlite` | Laravel 12.70.1, PHP 8.2.12; koneksi DB SQLite dipertahankan; APP_KEY lokal dibuat; migration sukses pada SQLite baru dan test memakai SQLite memori. |
| [x] | Pemeriksaan route resource | `routes/web.php` | `php artisan route:list --name=courses` menampilkan 8 route resource + availability. |
| [x] | Pemeriksaan Course Model | `app/Models/Course.php` | Fillable dan casts untuk tujuh field tersedia. |
| [x] | Implementasi CourseController | `app/Http/Controllers/CourseController.php` | CRUD memakai binding, validated data, redirect dan flash success; halaman di-render lewat automated test. |
| [x] | Implementasi StoreCourseRequest | `app/Http/Requests/StoreCourseRequest.php` | Aturan sesuai spesifikasi; dibuktikan dengan test validasi create. |
| [x] | Implementasi UpdateCourseRequest | `app/Http/Requests/UpdateCourseRequest.php` | Rule unique mengabaikan Course saat ini; test kode sendiri dan kode milik Course lain lulus. |
| [x] | Implementasi Show View | `resources/views/courses/show.blade.php` | Semua atribut dan tautan aksi ditampilkan; GET halaman show lulus. |
| [x] | Implementasi Edit View | `resources/views/courses/edit.blade.php`, `resources/views/courses/_form.blade.php` | Semua field, old value, format tanggal, CSRF dan PUT; GET dan spoofing diuji. |
| [x] | Perbaikan Index View | `resources/views/courses/index.blade.php` | Daftar, pencarian, filter, pagination, tombol CRUD dan empty state; GET diuji. |
| [x] | Implementasi Delete | `resources/views/courses/index.blade.php`, controller | Form DELETE dan dialog konfirmasi; test memastikan record terhapus dan redirect benar. |
| [x] | Validation feedback setiap field | `resources/views/courses/_form.blade.php`, `tests/Feature/CourseCrudTest.php` | Semua tujuh field memakai `@error` dan class `is-invalid`; test memicu dan memeriksa error untuk seluruh field. |
| [x] | Flash success message | `resources/views/layouts/app.blade.php`, CourseController | Layout menampilkan pesan; store/update/delete mem-flash success. Delete diuji eksplisit. |
| [x] | Route model binding | `routes/web.php`, CourseController | Binding untuk show/edit/update/destroy; ID yang tidak ada menghasilkan 404 dalam test. |
| [x] | Unique validation pada update | `app/Http/Requests/UpdateCourseRequest.php` | Mempertahankan kode sendiri diterima; kode Course lain ditolak. |
| [x] | Pengujian Create | `tests/Feature/CourseCrudTest.php` | Duplicate ditolak; quota boundary dan validasi terkait diuji. |
| [x] | Pengujian Read | `tests/Feature/CourseCrudTest.php` | Index menampilkan record; automated test lulus. |
| [x] | Pengujian Show | `tests/Feature/CourseCrudTest.php` | Detail dan atribut tampil; automated test lulus. |
| [x] | Pengujian Edit | `tests/Feature/CourseCrudTest.php` | Form tampil, tanggal awal benar; automated test lulus. |
| [x] | Pengujian Update | `tests/Feature/CourseCrudTest.php` | Update valid, kode sendiri, dan konflik kode diuji; automated test lulus. |
| [x] | Pengujian Delete | `tests/Feature/CourseCrudTest.php` | Record hilang setelah DELETE; automated test lulus. |
| [x] | Pengujian minimal 12 test case | `tests/Feature/CourseCrudTest.php`, `phpunit.xml` | 15 kasus inti dan test tambahan termasuk kelengkapan/idempotensi seeder; seluruh suite 24 test / 90 assertion lulus. Database test in-memory. |
| [x] | Pemeriksaan tampilan responsif | resources/views/courses, resources/views/partials/navbar.blade.php, resources/css/app.css, evidence/meeting-11/screenshots/ | Index diperiksa dengan Edge pada desktop 1365x900 dan ponsel 390x844. Header ponsel ditumpuk, tombol navigasi terlihat, dan tabel dapat digulir horizontal. |
| [x] | Pemeriksaan akhir project | `artisan`, routes, requests, migration, views, tests | Syntax PHP 29 file lulus; route list benar; `php artisan test`: 24 passed, 0 failed. SQLite lokal berisi 15 course. HTTP smoke test index/create menghasilkan 200. |
| [x] | Menyediakan 15 course lengkap | `database/seeders/CourseSeeder.php`, `database/seeders/DatabaseSeeder.php` | Menambahkan 15 course dengan kode unik, nama, deskripsi, biaya, kuota, tanggal, dan status. Seeder dipanggil oleh seeder utama. |
| [x] | Memverifikasi data dan keamanan record | SQLite lokal, `CourseSeeder` | `php artisan db:seed` berhasil dan aman diulang (`firstOrCreate`); hitungan akhir 15 course. Tidak ada course katalog yang dihapus. |
| [x] | Alur CRUD browser untuk bukti | Aplikasi lokal, Edge headless | Course dummy dibuat lewat form aplikasi, halaman detail/edit dibuka, data diupdate dan pesan sukses tampil, lalu dummy dihapus lewat form DELETE dan pesan sukses tampil. Hitungan katalog kembali 15. |
| [x] | Screenshot bukti pengumpulan | `evidence/meeting-11/index-course.png`, `detail-course.png`, `edit-course.png`, `update-success.png`, `delete-success.png` | Kelima file PNG diperiksa setelah ditangkap dari halaman aplikasi nyata di browser Edge. |

## Catatan tindakan manual

- Tidak ada pekerjaan implementasi atau verifikasi yang tertunda. Lima screenshot alur CRUD dan dua screenshot responsif tersedia di `evidence/meeting-11/`.

