<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HumanityScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('humanity_scores')->insert([
            [
                'score' => 20,
                'category' => '&#128683; Perlu Perhatian Serius',
                'description' => 'Sangat tidak sesuai harapan. Perlu bimbingan dan pendampingan intensif.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'score' => 40,
                'category' => '&#9888; Perlu Perbaikan',
                'description' => 'Mulai menunjukkan usaha, namun masih banyak kekurangan. Butuh motivasi dan arahan lanjutan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'score' => 60,
                'category' => '&#128578; Cukup',
                'description' => 'Sudah sesuai standar minimal. Ada potensi berkembang lebih baik dengan pembinaan rutin.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'score' => 80,
                'category' => '&#9989; Baik',
                'description' => 'Melaksanakan tugas dengan baik, konsisten, dan mulai jadi contoh bagi rekan lainnya.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'score' => 100,
                'category' => '&#127775; Sangat Baik / Inspiratif',
                'description' => 'Melebihi harapan. Tangguh, penuh inisiatif, dan menginspirasi. Layak diapresiasi & diteladani.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
