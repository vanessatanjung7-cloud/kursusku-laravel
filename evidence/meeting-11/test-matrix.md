# Test Matrix - Praktikum Pertemuan 11

Automated test dijalankan dengan PHPUnit/Laravel melalui `php artisan test` pada SQLite `:memory:`. SQLite lokal sebelumnya tidak ada; file baru dibuat dan migration dijalankan tanpa menghapus data yang sudah ada.

| No | Skenario | Expected Result | Actual Result | Status |
|---:|---|---|---|---|
| 1 | Duplicate code saat create | Ditolak oleh validasi unique | Error validasi `code`; test lulus | PASS (automated) |
| 2 | Nama kosong | Ditolak | Error validasi `name`; test lulus | PASS (automated) |
| 3 | Nama kurang dari 3 karakter | Ditolak | Error validasi `name`; test lulus | PASS (automated) |
| 4 | Fee negatif | Ditolak | Error validasi `fee`; test lulus | PASS (automated) |
| 5 | Fee bukan integer | Ditolak | Error validasi `fee`; test lulus | PASS (automated) |
| 6 | Quota 0 | Ditolak | Error validasi `quota`; test lulus | PASS (automated) |
| 7 | Quota 501 | Ditolak | Error validasi `quota`; test lulus | PASS (automated) |
| 8 | Quota 1 | Diterima | Record tersimpan dengan quota 1; test lulus | PASS (automated) |
| 9 | Quota 500 | Diterima | Record tersimpan dengan quota 500; test lulus | PASS (automated) |
| 10 | Tanggal tidak valid | Ditolak | Error validasi `start_date`; test lulus | PASS (automated) |
| 11 | Status bukan draft/open/closed | Ditolak | Error validasi `status`; test lulus | PASS (automated) |
| 12 | Update tanpa mengganti kode sendiri | Diterima | Update berhasil, redirect detail; test lulus | PASS (automated) |
| 13 | Update memakai kode Course lain | Ditolak | Error validasi `code`; test lulus | PASS (automated) |
| 14 | Update data valid | Diterima | Record terbarui dan flash success; test lulus | PASS (automated) |
| 15 | Delete Course | Terhapus dan kembali ke index | Record tidak ada, flash success benar; test lulus | PASS (automated) |

## Pengujian tambahan

- Index, show, dan edit mengembalikan HTTP 200 serta memuat konten yang diharapkan.
- Binding ID tidak tersedia menghasilkan HTTP 404.
- CSRF token dan method spoofing PUT/DELETE tersedia; aksi spoofed berhasil pada HTTP test.
- Error validasi dirender pada form.
- Create valid menyimpan Course dan menghasilkan flash success; error untuk ketujuh field diperiksa satu per satu dalam response form.
- Home route aplikasi tetap merespons HTTP 200.
- Syntax check: **29 file PHP lulus**.
- Hasil seluruh suite: **24 passed, 0 failed, 90 assertions** (termasuk kelengkapan dan idempotensi seeder).
- Setelah migration SQLite dan build Vite, HTTP smoke test GET `/courses` dan `/courses/create` menghasilkan 200; index memuat judul dan URL asset CSS.
- Edge headless menampilkan halaman index pada viewport desktop 1365x900 dan ponsel 390x844. Tombol navigasi ponsel diklik; `aria-expanded=true` dan menu memiliki class `show`.

Screenshot disimpan sebagai `screenshots/courses-index-desktop.png` dan `screenshots/courses-index-mobile.png`. Alur CRUD dibuktikan oleh automated tests; screenshot tidak digunakan untuk mengklaim interaksi CRUD manual.

## Data Course dan bukti browser

- `php artisan db:seed` berhasil. Seeder idempotent dan hitungan database setelah alur bukti: **15 course**.
- Browser membuat `AUDIT-DUMMY` lewat form, membuka detail/edit, memperbarui nama dan melihat pesan sukses, lalu menghapus dummy melalui form DELETE dan melihat pesan sukses. Dummy sudah tidak ada; 15 course katalog tetap tersimpan.

| Kode | Nama Course |
|---|---|
| KRS-001 | Web Dasar |
| KRS-002 | PHP Dasar |
| KRS-003 | Basis Data MySQL |
| KRS-004 | JavaScript Interaktif |
| KRS-005 | Laravel Dasar |
| KRS-006 | Laravel CRUD Lanjutan |
| KRS-007 | UI dan UX untuk Web |
| KRS-008 | Git dan Kolaborasi |
| KRS-009 | API dengan Laravel |
| KRS-010 | Keamanan Aplikasi Web |
| KRS-011 | Testing Laravel |
| KRS-012 | Frontend dengan Bootstrap |
| KRS-013 | Deployment Aplikasi Web |
| KRS-014 | Analisis Data dengan SQL |
| KRS-015 | Proyek Web Terpadu |

| Screenshot | Bukti |
|---|---|
| `index-course.png` | Halaman index katalog; database berisi 15 course dengan pagination |
| `detail-course.png` | Halaman detail course dummy |
| `edit-course.png` | Form edit dengan data awal |
| `update-success.png` | Halaman detail setelah update dan flash sukses |
| `delete-success.png` | Index setelah delete dan flash sukses |
| `screenshots/courses-index-desktop.png` | Pemeriksaan layout desktop |
| `screenshots/courses-index-mobile.png` | Pemeriksaan layout ponsel dan navigasi |

Pemeriksaan dilakukan lewat browser Edge headless dan screenshot nyata tersedia. Alur CRUD diverifikasi lewat automated tests dan browser headless.

