<?php

namespace Database\Seeders;

use App\Models\Participant;
use Illuminate\Database\Seeder;

class ParticipantSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['Alya Rahma', 'alya@example.test', '081200000001'],
            ['Bima Putra', 'bima@example.test', '081200000002'],
            ['Citra Nabila', 'citra@example.test', '081200000003'],
            ['Dinda Maharani', 'peserta04@example.test', '081200000004'],
            ['Edo Pratama', 'peserta05@example.test', '081200000005'],
            ['Fitri Lestari', 'peserta06@example.test', '081200000006'],
            ['Galang Saputra', 'peserta07@example.test', '081200000007'],
            ['Hana Putri', 'peserta08@example.test', '081200000008'],
            ['Indra Wijaya', 'peserta09@example.test', '081200000009'],
            ['Jihan Aulia', 'peserta10@example.test', '081200000010'],
            ['Kevin Saputra', 'peserta11@example.test', '081200000011'],
            ['Laila Safitri', 'peserta12@example.test', '081200000012'],
            ['Miko Aditya', 'peserta13@example.test', '081200000013'],
            ['Nadia Permata', 'peserta14@example.test', '081200000014'],
            ['Oscar Fernando', 'peserta15@example.test', '081200000015'],
            ['Putri Amelia', 'peserta16@example.test', '081200000016'],
            ['Rafi Hidayat', 'peserta17@example.test', '081200000017'],
            ['Salsa Kirana', 'peserta18@example.test', '081200000018'],
        ] as [$name, $email, $phone]) {
            Participant::firstOrCreate(
                ['email' => $email],
                ['name' => $name, 'phone' => $phone],
            );
        }
    }
}
