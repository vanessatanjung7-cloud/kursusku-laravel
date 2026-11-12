# Progress Praktikum Pertemuan 11

Pembaruan checklist Pertemuan 11: 11 November 2026. Lampiran Pertemuan 12: 12 November 2026.

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

## Catatan tindakan manual Pertemuan 11

- Tidak ada pekerjaan implementasi atau verifikasi yang tertunda. Lima screenshot alur CRUD dan dua screenshot responsif tersedia di `evidence/meeting-11/`.

## Praktikum Pertemuan 12 — Relational Database

Pembaruan: 12 November 2026.

| Status | Persyaratan | Verifikasi / catatan |
|---|---|---|
| [x] | Audit project dan versi Laravel | Laravel 12.70.1, PHP 8.2.12; status Git bersih sebelum perubahan; koneksi aplikasi SQLite; `.env` diperiksa tanpa menampilkan rahasia. |
| [x] | Migration participants | Kolom `name` 100, `email` 120 unique, `phone` nullable 20, id, timestamps. Migration incremental sudah `Ran`. |
| [x] | Migration enrollments | Foreign key ke participants dan courses dengan `constrained()->cascadeOnDelete()`, status default `registered`, unique gabungan participant/course. Migration incremental sudah `Ran`. |
| [x] | Urutan migration dan perlindungan data Course | Migration baru bertanggal setelah migration Course. Tidak menjalankan `migrate:fresh`; tabel Course dan 15 data Course tetap ada. |
| [x] | Relasi Eloquent | Relasi `hasMany`, `belongsTo`, dan many-to-many dengan pivot status/timestamps diperiksa dan diuji. |
| [x] | Data peserta contoh | Alya, Bima, dan Citra tersedia melalui `ParticipantSeeder` yang idempotent; hitungan SQLite lokal 3 peserta. |
| [x] | EnrollmentController | Controller PSR-4 bernama benar; index eager-load participant/course, create mengurutkan opsi, store memakai validasi dan flash success. |
| [x] | Route enrollment | Route resource hanya index/create/store; `route:list` menunjukkan `/enrollments`, `/enrollments/create`, POST `/enrollments`. Route Course tetap tersedia. |
| [x] | Form enrollment | CSRF, dropdown peserta/kursus, old input, validasi dekat field. Kursus berstatus `open` dipakai sebagai status aktif pada model Course project (status yang diizinkan existing adalah draft/open/closed). |
| [x] | Laporan enrollment | Tabel relasional memuat peserta, kursus, start date, status, tombol tambah, flash message dari layout, dan empty state. |
| [x] | Validasi dan pencegahan duplikasi | Rule unique bersyarat per participant, course harus open; composite unique diuji langsung pada SQLite. |
| [x] | Cascade delete | Dua test khusus membuktikan penghapusan Course/Participant menghapus Enrollment terkait dan menjaga entitas satunya. Dilakukan di SQLite in-memory. |
| [x] | Data lokal aman | Audit akhir: 15 Course, 3 Participant, dan 1 enrollment yang sudah ada; data Course dan enrollment existing dipertahankan. |
| [x] | Automated test | `php artisan test`: 50 passed, 0 failed, 207 assertions; mencakup CRUD Course, enrollment, dan navigasi. SQLite in-memory. |
| [x] | Route dan migration check | `php artisan route:list --except-vendor` menampilkan 16 route aplikasi, termasuk katalog, peserta, Course, dan enrollment; semua migration berstatus Ran. |
| [x] | Cache dan asset UI | `php artisan optimize:clear` dan `npm.cmd run build` berhasil. |
| [x] | Pemeriksaan halaman aplikasi | Beranda, katalog, detail/edit Course, peserta, form/laporan enrollment diperiksa di Edge. Klik mobile menu, Daftar Kursus, Detail, dan Daftarkan Peserta lulus; viewport 390px tidak horizontal overflow. |
| [x] | Screenshot aplikasi | Screenshot desktop halaman utama, katalog, kelola/detail/edit Course, peserta, enrollment; screenshot mobile dan menu mobile ada di `evidence/meeting-12/`. |
| [x] | Test matrix dan log | Hasil aktual dirangkum di `evidence/meeting-12/test-matrix.md` dan `evidence/meeting-12/ai-log.txt`. |
| [x] | ERD dan bukti skema | `evidence/meeting-12/erd.md` berisi ERD final; `schema-check.txt` menyimpan output aktual foreign key, cascade, unique index, dan jumlah data SQLite. |
| [x] | Ringkasan materi | Catatan relasi dan integritas database tersedia di `evidence/meeting-12/ringkasan-materi.md`. |
| [!] | Ekstraksi teks langsung dari PDF | File PDF terlampir ditemukan, tetapi lingkungan ini tidak memiliki PDF text extractor. Pengerjaan dicocokkan dengan instruksi Pertemuan 12 lengkap yang ditempelkan pengguna; pemeriksaan literal isi PDF sebaiknya dicocokkan manual bila PDF memiliki ketentuan tambahan. |
| [!] | Screenshot alur sukses/duplikasi untuk laporan | Screenshot halaman tersedia. Jika dosen meminta bukti visual transaksi, ambil screenshot setelah pesan sukses dan setelah validasi duplikasi; alur tersebut sudah lulus automated test. |

## Penyelesaian Enrollment CRUD dan data contoh

Pembaruan: 12 November 2026.

| Status | Pekerjaan | Verifikasi / catatan |
|---|---|---|
| [x] | Enrollment resource CRUD lengkap | Route index/create/store/show/edit/update/destroy, route model binding, halaman detail/edit, update, delete CSRF + DELETE + konfirmasi, dan flash sukses tersedia. |
| [x] | Validasi update enrollment | Peserta/kursus tervalidasi, status dibatasi, enrollment dapat mempertahankan pasangan sendiri, dan pasangan duplikat ditolak. Dibuktikan lewat feature tests. |
| [x] | Menu Kelola Enrollment | Navbar dan halaman daftar menghubungkan laporan, detail, edit, tambah, dan hapus enrollment. |
| [x] | 15 data enrollment contoh | `EnrollmentSeeder` membuat 15 pasangan peserta-kursus via `firstOrCreate`, dipanggil oleh `DatabaseSeeder`, aman dijalankan ulang. |
| [x] | Data lokal diverifikasi | Database lokal berisi 15 Course, 3 Participant, dan 16 Enrollment: 15 data contoh baru serta 1 data lama yang tetap dipertahankan. |
| [x] | Pengujian final | `php artisan test`: 55 passed, 0 failed, 232 assertions menggunakan SQLite in-memory. Test mencakup detail/edit/update/delete dan seeder 15 data idempotent. |
| [x] | Route, syntax, dan asset | Route resource diperiksa; PHP lint dan `npm.cmd run build` berhasil. Tidak menjalankan `migrate:fresh` atau `db:wipe`. |

