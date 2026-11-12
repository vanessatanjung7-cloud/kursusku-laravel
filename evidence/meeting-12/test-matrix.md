# Test Matrix — Praktikum Pertemuan 12

Tanggal verifikasi: 12 November 2026. Semua test feature menggunakan SQLite in-memory dari `phpunit.xml`; database lokal tidak dipakai oleh suite test.

## Enrollment tests

| No. | Skenario | Hasil aktual |
|---:|---|---|
| 1 | Laporan menampilkan participant, course, start date, status dari relasi | PASS |
| 2 | Laporan tanpa enrollment menampilkan empty state dan tautan tambah | PASS |
| 3 | Endpoint availability menghitung jumlah enrollment aktual | PASS |
| 4 | Form mengurutkan peserta/kursus dan hanya menampilkan course `open` | PASS |
| 5 | Enrollment valid tersimpan dengan status `registered` dan flash sukses | PASS |
| 6 | Participant wajib; nilai course lama tetap di session ketika validasi gagal | PASS |
| 7 | ID participant yang tidak ada ditolak | PASS |
| 8 | Course wajib diisi | PASS |
| 9 | ID course yang tidak ada ditolak | PASS |
| 10 | Course `closed` tidak dapat didaftarkan | PASS |
| 11 | Participant yang sama tidak dapat mengambil course yang sama dua kali melalui validation | PASS |
| 12 | Participant berbeda boleh mengambil course yang sama | PASS |
| 13 | Participant yang sama boleh mengambil course berbeda | PASS |
| 14 | Skenario Alya Laravel, duplikasi ditolak, Alya PHP, Bima Laravel | PASS |
| 15 | Composite unique database menolak duplikasi langsung | PASS |
| 16 | Relasi many-to-many membawa pivot status/timestamps; relasi hasMany tersedia | PASS |
| 17 | Hapus Course menghapus Enrollment terkait tetapi mempertahankan Participant | PASS |
| 18 | Hapus Participant menghapus Enrollment terkait tetapi mempertahankan Course | PASS |
| 19 | ParticipantSeeder aman dijalankan berulang dan menghasilkan 3 data | PASS |
| 20 | Route/form pendaftaran lama `/pendaftaran` tetap tersedia | PASS |

Delapan skenario E2E dari instruksi telah dilakukan melalui test HTTP Laravel: buka form, participant kosong, course kosong, daftar Alya ke Laravel, tolak percobaan duplikat, daftar Alya ke PHP, daftar Bima ke Laravel, dan cek halaman laporan. Hasil tiap request tercantum di skenario enrollment di atas.

## Course tests yang tetap berjalan

Suite `tests/feature/CourseCrudTest.php` menjalankan 22 skenario CRUD, validasi, route model binding, CSRF/method spoofing, halaman index/show/edit, dan CourseSeeder. Seluruh 22 lulus. Detail kasus ada di [test matrix Pertemuan 11](../meeting-11/test-matrix.md).

Laravel juga menjalankan 2 test contoh bawaan (unit dan feature); keduanya lulus.

## Navigation integration tests

`tests/feature/NavigationTest.php` contributes 6 feature tests:

| No. | Skenario | Hasil aktual |
|---:|---|---|
| 1 | Navigation menu mengarah ke katalog, CRUD Course, peserta, dan laporan | PASS |
| 2 | Beranda merender Course dari database dan link CTA katalog | PASS |
| 3 | Katalog menampilkan Course open, detail, dan link enrollment | PASS |
| 4 | Hasil pencarian AJAX merender fragment, bukan layout penuh | PASS |
| 5 | Link peserta dan Course mengisi pilihan form enrollment | PASS |
| 6 | Halaman utama integrasi merespons sukses | PASS |

## Ringkasan run final

- Perintah: `php artisan test`
- Test: **50 passed, 0 failed**
- Assertions: **207**
- Durasi run final: **3.63 detik**
- Test database: SQLite in-memory

Run awal menemukan satu kegagalan pada fixture test urutan pilihan (test mengharapkan Laravel Dasar tanpa membuat Course tersebut). Fixture diperbaiki. Hasil PASS di tabel ini adalah hasil run final setelah perbaikan.

## Pemeriksaan integrasi tambahan

| Pemeriksaan | Hasil aktual |
|---|---|
| `php artisan route:list --except-vendor` | PASS — 16 route aplikasi termasuk katalog, peserta, Course dan Enrollment |
| `php artisan route:list --path=enrollments` | PASS — index, create, store |
| `php artisan migrate:status` setelah migration | PASS — semua migration berstatus Ran |
| Migration lokal incremental | PASS — hanya dua tabel baru; tidak memakai `migrate:fresh` |
| SQLite foreign key list | PASS — 2 foreign key aktif pada tabel enrollments |
| SQLite index list | PASS — `enrollments_participant_id_course_id_unique` |
| SQLite participant email index | PASS — `participants_email_unique` |
| Data lokal sesudah audit navigasi | PASS — 15 courses, 3 participants, 1 enrollment existing; dipertahankan |
| HTTP `/enrollments` dan `/enrollments/create` | PASS — keduanya status 200 |
| `php artisan optimize:clear` | PASS |
| `npm.cmd run build` | PASS — Vite 7.3.7, 123 modules transformed |
| Screenshot halaman aplikasi | PASS — PNG nyata dari Edge headless; home, katalog, Course index/detail/edit, peserta, enrollment, dan mobile |
| Klik alur browser mobile | PASS — menu, katalog, detail Course, dan CTA enrollment; viewport 390px tanpa overflow horizontal |

PDF sumber ada di Downloads tetapi tidak berhasil diekstrak sebagai teks karena PDF text extractor tidak tersedia. Matrix ini dicocokkan terhadap instruksi Pertemuan 12 lengkap yang disertakan pengguna. Lihat catatan di `PROGRESS_PRAKTIKUM.md`.
