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
            ],
            [
                'name' => 'TI-1B',

            ],
            [
                'name' => 'TI-1C',

            ],
        ];

        foreach ($kelas as $kls) {
            Kelas::create($kls);
        }
    }
}
