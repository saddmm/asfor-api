<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Report;
use App\Models\Task;
use App\Models\Finance;
use App\Models\Event;
use App\Models\Lab;
use App\Models\InventoryItem;
use App\Models\AppNotification;
use App\Models\Election;
use App\Models\ElectionCandidate;
use App\Models\ElectionVote;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        $users = User::all();
        if ($users->isEmpty()) {
            $this->command->info('No users found. Please seed users first.');
            return;
        }

        $divisions = [
            'Hubungan Masyarakat', 'IT Support', 'Pemrograman', 
            'Training', 'Bidang Usaha', 'Badan Pengurus Harian'
        ];

        $reportTitles = ['Laporan Bulanan Divisi', 'Evaluasi Program Kerja', 'Laporan Keuangan Mingguan', 'Rekapitulasi Absensi Anggota', 'Progress Project Website', 'Hasil Rapat Evaluasi', 'Pengajuan Dana Kegiatan', 'Laporan Kerusakan Inventaris'];
        $reportDescs = ['Laporan ini disusun sebagai bentuk pertanggungjawaban atas program kerja yang telah berjalan selama satu bulan terakhir.', 'Mohon diperiksa kembali detail pengeluaran dan dilampirkan bukti nota.', 'Kegiatan berjalan lancar dengan tingkat kehadiran mencapai target.', 'Ditemukan beberapa kendala pada server, sehingga diperlukan pemeliharaan darurat.', 'Target telah tercapai sesuai dengan timeline yang ditentukan.'];

        $taskTitles = ['Perbaikan Server Database', 'Desain Banner Kegiatan', 'Setup Jaringan Lab', 'Rapat Koordinasi', 'Penyusunan Modul Pelatihan', 'Mencari Sponsor Acara', 'Maintenance Website', 'Pembelian ATK', 'Update Data Anggota'];
        $taskDescs = ['Harap diselesaikan sebelum tenggat waktu karena ini adalah prioritas tinggi.', 'Kerjakan dengan tim divisi, pastikan hasilnya rapi.', 'Mohon koordinasi dengan BPH untuk masalah anggaran.', 'Silakan dicicil pekerjaannya, tidak perlu terburu-buru.', 'Pastikan dokumentasi diunggah ke Google Drive setelah selesai.'];

        $finDescs = ['Pembelian Kertas HVS', 'Biaya Hosting Server', 'Konsumsi Rapat Pleno', 'Sewa Proyektor', 'Dana Usaha Penjualan', 'Donasi Alumni', 'Pembelian Kabel LAN', 'Pembuatan Sertifikat', 'Biaya Print dan Fotokopi'];

        $eventTitles = ['Rapat Kerja Pengurus', 'Pelatihan Web Development', 'Seminar IT Nasional', 'Upgrading Anggota Baru', 'Buka Bersama', 'Kunjungan Industri', 'Lomba Desain Poster', 'Diskusi Panel Teknologi'];

        $this->command->info('Creating 100 Reports...');
        for ($i = 0; $i < 100; $i++) {
            $status = $faker->randomElement(['pending', 'approved', 'rejected']);
            $submitted_by = $users->random()->name;
            $approved_by = $status !== 'pending' ? $users->where('role', 'admin')->random()->name : null;
            
            Report::create([
                'title' => $faker->randomElement($reportTitles) . ' ' . $faker->numberBetween(1, 10),
                'division' => $faker->randomElement($divisions),
                'date' => $faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
                'budget' => $faker->randomFloat(2, 50000, 5000000),
                'description' => $faker->randomElement($reportDescs),
                'status' => $status,
                'submitted_by' => $submitted_by,
                'approved_by' => $approved_by,
                'approved_at' => $status !== 'pending' ? now() : null,
                'rejection_note' => $status === 'rejected' ? 'Revisi format lampiran dan cek ulang total anggaran.' : null,
            ]);
        }

        $this->command->info('Creating 100 Tasks...');
        for ($i = 0; $i < 100; $i++) {
            Task::create([
                'title' => $faker->randomElement($taskTitles),
                'description' => $faker->randomElement($taskDescs),
                'assigned_to' => $users->random()->id,
                'assigned_by' => $users->where('role', 'admin')->random()->id,
                'division' => $faker->randomElement($divisions),
                'priority' => $faker->randomElement(['low', 'medium', 'high', 'urgent']),
                'status' => $faker->randomElement(['pending', 'in_progress', 'completed']),
            ]);
        }

        $this->command->info('Creating 100 Finances...');
        for ($i = 0; $i < 100; $i++) {
            Finance::create([
                'type' => $faker->randomElement(['income', 'expense']),
                'amount' => $faker->randomFloat(2, 10000, 2000000),
                'date' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'category' => $faker->randomElement(['Konsumsi', 'Operasional', 'Sponsor', 'Lainnya']),
                'description' => $faker->randomElement($finDescs),
            ]);
        }

        $this->command->info('Creating Labs and 100 Inventory Items...');
        $labs = [];
        for ($i = 1; $i <= 5; $i++) {
            $lab = Lab::create([
                'name' => 'Lab ' . $faker->randomElement(['Komputer', 'Jaringan', 'Riset', 'Multimedia', 'Software']) . ' ' . $i,
                'description' => 'Ruangan lab yang digunakan untuk menunjang kegiatan praktikum dan riset mahasiswa.',
            ]);
            $labs[] = $lab;
        }

        for ($i = 0; $i < 100; $i++) {
            InventoryItem::create([
                'lab_id' => $faker->randomElement($labs)->id,
                'name' => $faker->randomElement(['PC Server', 'Monitor LED 24"', 'Keyboard Mechanical', 'Mouse Wireless', 'Router Mikrotik', 'Switch Hub 24 Port', 'Proyektor Epson', 'Kabel LAN UTP Cat 6']),
                'quantity' => $faker->numberBetween(1, 20),
                'condition' => $faker->randomElement(['baik', 'rusak', 'perbaikan']),
                'notes' => $faker->randomElement(['Barang dalam kondisi baik dan siap digunakan.', 'Perlu dilakukan pengecekan ulang minggu depan.', 'Sebagian unit mengalami kerusakan minor.', 'Barang baru saja dibeli bulan lalu.']),
            ]);
        }

        $this->command->info('Creating 100 Events...');
        for ($i = 0; $i < 100; $i++) {
            Event::create([
                'title' => $faker->randomElement($eventTitles),
                'description' => 'Kegiatan rutin yang wajib diikuti oleh seluruh anggota divisi terkait untuk meningkatkan kapasitas organisasi.',
                'event_date' => $faker->dateTimeBetween('-3 months', '+3 months')->format('Y-m-d'),
                'event_time' => $faker->time('H:i:s'),
                'location' => $faker->randomElement(['Ruang Rapat Utama', 'Aula Fakultas', 'Gedung Serbaguna', 'Via Zoom Meeting', 'Google Meet']),
                'division' => $faker->randomElement(array_merge($divisions, ['Semua'])),
                'created_by' => $users->random()->id,
            ]);
        }

        $notifTitles = ['Tugas Baru Diberikan', 'Laporan Anda Diterima', 'Pengingat Rapat', 'Informasi Penting', 'Perubahan Jadwal'];
        $notifBodies = ['Silakan cek task manager Anda, ada tugas baru dengan prioritas tinggi.', 'Laporan yang Anda ajukan telah disetujui oleh BPH.', 'Jangan lupa, rapat koordinasi akan diadakan besok jam 1 siang.', 'Terdapat pembaruan informasi dari ketua divisi.', 'Jadwal kegiatan diundur satu hari, mohon menyesuaikan.'];

        $this->command->info('Creating 100 Notifications...');
        for ($i = 0; $i < 100; $i++) {
            AppNotification::create([
                'user_id' => $users->random()->id,
                'title' => $faker->randomElement($notifTitles),
                'body' => $faker->randomElement($notifBodies),
                'type' => $faker->randomElement(['info', 'warning', 'success', 'task', 'report']),
                'read_at' => $faker->boolean(60) ? now() : null,
                'data' => json_encode(['link' => '/home']),
            ]);
        }

        $this->command->info('Creating 1 Election and 100 Votes...');
        $election = Election::create([
            'title' => 'Pemilihan Ketua Organisasi Periode Depan',
            'status' => 'active',
        ]);

        $candidates = [];
        $visis = ['Mewujudkan organisasi yang unggul, inovatif, dan berprestasi.', 'Menjadi wadah aspirasi anggota yang inklusif dan solutif.', 'Meningkatkan kualitas sumber daya manusia organisasi secara berkelanjutan.'];
        for ($i = 1; $i <= 3; $i++) {
            $candidates[] = ElectionCandidate::create([
                'election_id' => $election->id,
                'user_id' => $users->random()->id,
                'visi_misi' => "Visi:\n" . $visis[$i-1] . "\n\nMisi:\n1. Meningkatkan komunikasi antar anggota.\n2. Menjalankan program kerja secara profesional.\n3. Mengoptimalkan pengembangan skill IT.",
            ]);
        }

        // Each user can vote once
        $votedUsers = $users->random(min(100, $users->count()));
        foreach ($votedUsers as $vu) {
            ElectionVote::create([
                'election_id' => $election->id,
                'candidate_id' => $faker->randomElement($candidates)->id,
                'voter_id' => $vu->id,
            ]);
        }

        $this->command->info('Successfully seeded 100 dummy records for each feature!');
    }
}
