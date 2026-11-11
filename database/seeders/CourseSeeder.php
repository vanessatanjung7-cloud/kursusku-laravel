<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            ['KRS-001', 'Web Dasar', 'Belajar HTML, CSS, aksesibilitas, dan dasar membangun halaman web responsif.', 350000, 30, '2026-12-05', 'open'],
            ['KRS-002', 'PHP Dasar', 'Dasar PHP, tipe data, percabangan, perulangan, fungsi, dan pemrosesan form.', 400000, 28, '2026-12-08', 'open'],
            ['KRS-003', 'Basis Data MySQL', 'Perancangan relasi, SQL, normalisasi, indeks, dan transaksi menggunakan MySQL.', 450000, 24, '2026-12-12', 'open'],
            ['KRS-004', 'JavaScript Interaktif', 'Fundamental JavaScript, DOM, event, asynchronous request, dan antarmuka interaktif.', 500000, 25, '2026-12-15', 'open'],
            ['KRS-005', 'Laravel Dasar', 'Membangun aplikasi Laravel dengan route, controller, Blade, model, dan migration.', 650000, 24, '2026-12-19', 'open'],
            ['KRS-006', 'Laravel CRUD Lanjutan', 'Praktik validasi Form Request, route model binding, update, dan delete yang aman.', 700000, 20, '2027-01-06', 'open'],
            ['KRS-007', 'UI dan UX untuk Web', 'Prinsip desain antarmuka, prototyping, usability, dan evaluasi pengalaman pengguna.', 425000, 26, '2027-01-10', 'draft'],
            ['KRS-008', 'Git dan Kolaborasi', 'Mengelola version control, branch, pull request, dan workflow kolaborasi tim.', 300000, 32, '2027-01-13', 'open'],
            ['KRS-009', 'API dengan Laravel', 'Merancang REST API, autentikasi token, resource response, dan dokumentasi endpoint.', 625000, 22, '2027-01-17', 'open'],
            ['KRS-010', 'Keamanan Aplikasi Web', 'Mengenali risiko umum web serta menerapkan validasi, otorisasi, dan perlindungan CSRF.', 575000, 18, '2027-01-20', 'draft'],
            ['KRS-011', 'Testing Laravel', 'Menulis feature dan unit test, menyiapkan database testing, dan membaca hasil PHPUnit.', 550000, 20, '2027-01-24', 'open'],
            ['KRS-012', 'Frontend dengan Bootstrap', 'Membuat layout responsif dan komponen antarmuka memakai Bootstrap 5.', 375000, 30, '2027-01-27', 'open'],
            ['KRS-013', 'Deployment Aplikasi Web', 'Menyiapkan konfigurasi produksi, asset build, server, dan proses rilis aplikasi.', 600000, 16, '2027-02-03', 'draft'],
            ['KRS-014', 'Analisis Data dengan SQL', 'Mengolah data menggunakan query agregasi, join, subquery, dan laporan SQL.', 475000, 22, '2027-02-07', 'closed'],
            ['KRS-015', 'Proyek Web Terpadu', 'Menerapkan analisis kebutuhan, desain, CRUD, pengujian, dan dokumentasi dalam proyek tim.', 800000, 18, '2027-02-10', 'open'],
        ];

        foreach ($courses as [$code, $name, $description, $fee, $quota, $startDate, $status]) {
            Course::firstOrCreate(
                ['code' => $code],
                [
                    'name' => $name,
                    'description' => $description,
                    'fee' => $fee,
                    'quota' => $quota,
                    'start_date' => $startDate,
                    'status' => $status,
                ],
            );
        }
    }
}
