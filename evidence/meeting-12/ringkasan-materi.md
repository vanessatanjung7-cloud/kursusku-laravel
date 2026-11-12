# Ringkasan Materi — Relational Database di Laravel

## Relasi data

`Course` memiliki banyak `Enrollment`, dan `Participant` juga memiliki banyak `Enrollment`. Tabel `enrollments` menjadi tabel penghubung. Dengan begitu Participant dan Course memiliki relasi many-to-many melalui Enrollment.

Di Eloquent, `hasMany` digunakan dari Course/Participant ke Enrollment. Enrollment memakai `belongsTo` ke masing-masing induknya. Relasi `belongsToMany` memudahkan membaca kursus seorang peserta atau peserta dalam suatu kursus. `withPivot('status')` mengambil status pendaftaran dari tabel penghubung; `withTimestamps()` menjaga waktu pembuatan/perubahan pivot.

## Integritas database

Foreign key `participant_id` dan `course_id` memastikan setiap enrollment merujuk ke data yang benar. `cascadeOnDelete()` menghapus baris enrollment jika Course atau Participant induk dihapus. Data induk yang lain tidak ikut terhapus.

Composite unique `(participant_id, course_id)` menjaga satu peserta tidak tercatat dua kali pada kursus yang sama. Validasi Laravel memberi pesan yang ramah sebelum insert; unique constraint database tetap menjadi perlindungan terakhir jika ada dua request bersamaan atau data masuk di luar form.

## Alur request enrollment

Browser mengirim POST ke route `enrollments.store` dengan CSRF token. Controller memvalidasi participant dan Course, menolak Course yang tidak berstatus `open`, dan mengecek pasangan unik. Setelah tervalidasi, status `registered` ditambahkan server-side sebelum model menyimpan data. Pengguna diarahkan kembali ke laporan dengan flash message.

Laporan menggunakan eager loading `with(['participant', 'course'])`, sehingga detail relasi dibaca tanpa query terpisah untuk setiap baris. Kolom tanggal mulai ditampilkan dari `course.start_date`.

## Status course pada project

Validasi dan seed Course dari Pertemuan 11 memakai status `draft`, `open`, dan `closed`. Implementasi Pertemuan 12 memakai `open` sebagai status aktif/tersedia untuk pendaftaran agar tidak mengubah aturan Course yang sudah berjalan.
