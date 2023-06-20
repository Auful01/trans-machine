<?php

namespace App\Http\Controllers;

use App\Helpers\UsersImport;
use App\Http\Traits\Response;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    use Response;

    public function index()
    {
        try {
            $user = User::with('role')->where('email', '!=', null)->get();

            return $this->success($user, 'Data user berhasil diambil');
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $user = User::with('role')->find($id);

            return $this->success($user, 'Data user berhasil diambil');
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    public function importUser(Request $request)
    {

        $import = new UsersImport;
        Excel::import($import, $request->file('file_mhs'));

        if (!$import) {
            return $this->error("Data gagal Disimpan");
        }

        return $this->success('Data Berhasil disimpan');
    }
}
