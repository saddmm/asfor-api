<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        User::firstOrCreate(['email' => 'admin'], [
            'name' => 'Melina', 'password' => Hash::make('password'), 'role' => 'admin', 'division' => 'Semua Divisi'
        ]);

        $users = [
            // IT Support
            ['nim' => '221080200072', 'name' => 'Rizky', 'division' => 'IT Support', 'role' => 'user'],
            ['nim' => '221080200135', 'name' => 'Athallah', 'division' => 'IT Support', 'role' => 'user'],
            ['nim' => '221080200117', 'name' => 'WahyuAlvy ', 'division' => 'IT Support', 'role' => 'user'],
            ['nim' => '221080200145', 'name' => 'Rizky', 'division' => 'IT Support', 'role' => 'user'],
            ['nim' => '231080200081', 'name' => 'Achmad', 'division' => 'IT Support', 'role' => 'user'],
            ['nim' => '231080200097', 'name' => 'Bryan', 'division' => 'IT Support', 'role' => 'user'],
            ['nim' => '231080200047', 'name' => 'Abiyyu', 'division' => 'IT Support', 'role' => 'user'],

            // Training
            ['nim' => '221080200150', 'name' => 'Steven', 'division' => 'Training', 'role' => 'user'],
            ['nim' => '221080200151', 'name' => 'Azizah', 'division' => 'Training', 'role' => 'user'],
            ['nim' => '231080200150', 'name' => 'Nadtasya', 'division' => 'Training', 'role' => 'user'],
            ['nim' => '241080200140', 'name' => 'Bintang', 'division' => 'Training', 'role' => 'user'],
            ['nim' => '241080200054', 'name' => 'Nadya', 'division' => 'Training', 'role' => 'user'],

            // Humas (Hubungan Masyarakat)
            ['nim' => '221080200087', 'name' => 'Ditta', 'division' => 'Hubungan Masyarakat', 'role' => 'user'],
            ['nim' => '221080200086', 'name' => 'Hafizh', 'division' => 'Hubungan Masyarakat', 'role' => 'user'],
            ['nim' => '231080200141', 'name' => 'Arya', 'division' => 'Hubungan Masyarakat', 'role' => 'user'],
            ['nim' => '241080200041', 'name' => 'Zianisa', 'division' => 'Hubungan Masyarakat', 'role' => 'user'],

            // Programmer (Pemrograman)
            ['nim' => '221080200106', 'name' => 'Luluk', 'division' => 'Pemrograman', 'role' => 'user'],
            ['nim' => '221080200136', 'name' => 'Ananda', 'division' => 'Pemrograman', 'role' => 'user'],
            ['nim' => '231080200118', 'name' => 'Julia', 'division' => 'Pemrograman', 'role' => 'user'],
            ['nim' => '241080200065', 'name' => 'Apriza', 'division' => 'Pemrograman', 'role' => 'user'],
            ['nim' => '241080200059', 'name' => 'Emilia', 'division' => 'Pemrograman', 'role' => 'user'],

            // Bidang Usaha
            ['nim' => '241080200099', 'name' => 'Aulia', 'division' => 'Bidang Usaha', 'role' => 'user'],
            ['nim' => '251080200151', 'name' => 'Dhea', 'division' => 'Bidang Usaha', 'role' => 'user'],

            // BPH (Badan Pengurus Harian) - Role Admin
            ['nim' => '221080200131', 'name' => 'Saddam', 'division' => 'Badan Pengurus Harian', 'role' => 'admin'],
            ['nim' => '231080200060', 'name' => 'Isvander', 'division' => 'Badan Pengurus Harian', 'role' => 'admin'],
            ['nim' => '221080200107', 'name' => 'Vilary', 'division' => 'Badan Pengurus Harian', 'role' => 'admin'],
            ['nim' => '221080200103', 'name' => 'Annifa', 'division' => 'Badan Pengurus Harian', 'role' => 'admin'],
        ];

        foreach ($users as $u) {
            User::firstOrCreate(['email' => $u['nim']], [
                'name' => $u['name'],
                'password' => Hash::make('password'),
                'role' => $u['role'],
                'division' => $u['division']
            ]);
        }
    }
}
