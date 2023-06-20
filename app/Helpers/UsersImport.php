<?php

namespace App\Helpers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{

    private $rows = 0;

    public function model(array $row)
    {
        ++$this->rows;
        if ($row != 1) {
            # code...
            $data = new User([
                'name' => $row[0],
                'identity_num' => $row[1],
                'email' => $row[1] . '@xyz.com',
                'password' => Hash::make($row[1])
            ]);
            $data->save();

            // dd($data->id);

            return new  Mahasiswa([
                'user_id' => $data->id,
                'nim' => $row[1],
                'kelas_id' => $row[2]
            ]);
        }
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }
}
