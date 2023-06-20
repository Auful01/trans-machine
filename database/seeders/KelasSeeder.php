<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kelas = [
            [
                'name' => 'TI-1A',
                'dosen_id' => '3'
            ],
            [
                'name' => 'TI-1B',
                'dosen_id' => '3'
            ],
            [
                'name' => 'TI-1C',
                'dosen_id' => '3'
            ],
        ];

        foreach ($kelas as $kls) {
            Kelas::create($kls);
        }
    }
}
