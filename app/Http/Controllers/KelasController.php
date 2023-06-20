<?php

namespace App\Http\Controllers;

use App\Http\Traits\Response;
use App\Models\Dosen;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    use Response;
    public function index()
    {
        try {
            $data = Kelas::all();

            return $this->success($data, 'Data Berhasil diambil');
        } catch (\Throwable $th) {
            //throw $th;
            return $this->error($th->getMessage(), $th->getCode());
        }
    }

    public function myKelas()
    {
        try {
            // dd(Auth::user()->id);
            $data = Dosen::where('user_id', auth()->user()->id)->first();
            if ($data != null) {
                # code...
                $kelas = json_decode($data->kelas);
                $dataRet = [];

                foreach ($kelas as $key => $value) {
                    $dataRet[] = Kelas::find($value);
                }

                $data['list_kelas'] = $dataRet;
                return $this->success($data, 'Data Berhasil diambil');
            } else {
                return $this->success([], 'Data Berhasil diambil');
            }

            // dd($data);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            return $this->error($th->getMessage(), $th->getCode());
        }
    }

    public function show($id)
    {
        try {
            $data = Kelas::find($id);

            return $this->success($data, "Data Berhasil Ditemukan");
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->error($th->getMessage(), $th->getCode());
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = Kelas::create($request->all());

            DB::commit();

            return $this->success($data, "Data Berhasil disimpan");
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->error($th->getMessage(), $th->getCode());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $data = Kelas::find($id)->update($request->all());

            DB::commit();

            return $this->success($data, "Data Berhasil Disimpan");
        } catch (\Throwable $th) {
            //throw $th;
            return $this->error($th->getMessage(), $th->getCode());
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $data = Kelas::find($id)->delete();

            DB::commit();
            return $this->success($data, "Berhasil Dihapus");
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->error($th->getMessage(), $th->getCode());
        }
    }
}
