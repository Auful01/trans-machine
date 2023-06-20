<?php

namespace App\Http\Controllers;

use App\Http\Traits\Response;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Termwind\Components\Dd;

class DosenController extends Controller
{

    use Response;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $dosen = Dosen::with('user')->get();

            return $this->success($dosen, 'Data dosen berhasil diambil');
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:users',
                'nidn' => 'required|unique:dosen',
                'kelas' => 'required',
                'no_hp' => 'required',
            ], [
                'name.required' => 'Nama tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'email.unique' => 'Email sudah terdaftar',
                'nidn.required' => 'NIDN tidak boleh kosong',
                'nidn.unique' => 'NIDN sudah terdaftar',
                'kelas.required' => 'Kelas tidak boleh kosong',
                'no_hp.required' => 'No HP tidak boleh kosong',
            ]);

            if ($validator->fails()) {
                $error = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $error .= $value . ", ";
                }
                return $this->error($error);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'identity_num' => $request->nidn,
                'password' => bcrypt('password'),
                'role_id' => 2,
            ]);
            // dd($request->all());
            $request->merge([
                'user_id' => $user->id,
            ]);
            $request['kelas'] = json_encode($request->kelas);
            $dosen = Dosen::create($request->all());
            DB::commit();
            return $this->success($dosen, 'Data dosen berhasil ditambahkan');
        } catch (\Throwable $th) {
            db::rollback();
            return $this->error($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $dosen = Dosen::with('user')->find($id);
            $kelas = json_decode($dosen['kelas']);
            $test = [];
            foreach ($kelas as $key => $value) {
                array_push($test, Kelas::find($value)->name);
            }
            $dosen['kelas'] = $test;
            return $this->success($dosen, 'Data dosen berhasil diambil');
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function edit(Dosen $dosen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $dosen = Dosen::find($id);
            $dosen->update([
                'user_id' => $request->user_id,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'nidn' => $request->nidn,
                'jabatan' => $request->jabatan,
                'pendidikan' => $request->pendidikan,
                'jurusan' => $request->jurusan,
                'prodi' => $request->prodi,
                'fakultas' => $request->fakultas,
                'universitas' => $request->universitas,
                'foto' => $request->foto,
                'cv' => $request->cv,
                'sk' => $request->sk,
                'status' => $request->status,
            ]);

            return $this->success($dosen, 'Data dosen berhasil diubah');
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $dosen = Dosen::find($id);
            $dosen->delete();

            return $this->success($dosen, 'Data dosen berhasil dihapus');
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }
}
