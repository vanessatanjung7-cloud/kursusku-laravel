# KursusKu

Project praktikum Pemrograman Web III. Aplikasi memakai Laravel 12, PHP 8.2+, dan SQLite/MySQL sesuai konfigurasi `.env`.

## Menjalankan project

1. Pasang dependency PHP dengan `composer install`.
2. Jika `.env` belum ada, salin `.env.example` menjadi `.env`; atur koneksi database lokal. Jangan commit file `.env`.
3. Jika `APP_KEY` belum tersedia, jalankan `php artisan key:generate`.
4. Jalankan migration dan data contoh secara additive dengan `php artisan migrate --seed`. Jangan gunakan `migrate:fresh` pada database yang berisi data penting.
5. Pasang dependency frontend jika diperlukan dengan `npm install`, lalu jalankan `npm run dev` (Windows: `npm.cmd run dev`).
6. Jalankan `php artisan serve`, lalu buka URL yang ditampilkan.

## Fitur

- CRUD Course dengan validasi Form Request, route model binding, flash message, dan form delete ber-CSRF.
- Relasi Course–Enrollment–Participant, CRUD Enrollment lengkap, pencegahan data ganda, laporan relasional, dan cascade delete.
- Database seeder menambahkan 15 pasangan contoh Enrollment secara idempotent bersama Course dan Participant.
- Pendaftaran lama `/pendaftaran` tetap tersedia sebagai preview; alur enrollment berbasis database ada di `/enrollments/create`.

## Route penting

- `/courses/catalog` — katalog kursus yang sedang dibuka.
- `/courses` — kelola/CRUD Course.
- `/courses/create` — tambah Course.
- `/participants` — daftar peserta.
- `/enrollments` — daftar/kelola enrollment.
- `/enrollments/create` — form enrollment.
- `/enrollments/{id}` dan `/enrollments/{id}/edit` — detail dan edit enrollment.
- `/pendaftaran` — form preview pendaftaran lama.

## Test dan dokumentasi

- Jalankan `php artisan test`. Test memakai SQLite in-memory dari `phpunit.xml`.
- Progress praktikum ada di `PROGRESS_PRAKTIKUM.md`.
- Matriks dan screenshot Pertemuan 11/12 ada di `evidence/meeting-11/` dan `evidence/meeting-12/`.
