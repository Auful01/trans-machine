<?php

namespace App\Http\Controllers;

use App\Http\Traits\Response;
use App\Models\Mahasiswa;
use App\Models\PenugasanMahasiswa;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Throw_;
use PDF;

class MahasiswaController extends Controller
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
            $data = User::with('mahasiswa')->where('users.role_id', 3)->get();

            return  $this->success($data, 'data berhasil diambil');
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    public function getByKelas($id)
    {
        try {
            $data = Mahasiswa::with('user')->where('kelas_id', $id)->get();

            return  $this->success($data, 'data berhasil diambil');
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
            $request['email'] = $request->nim . '@xyz.com';
            $request['password'] = bcrypt('password');
            $request['role_id'] = 3;
            $request['identity_num'] = $request->nim;
            $user = User::create($request->all());
            Mahasiswa::create([
                'user_id' => $user['id'],
                'kelas_id' => $request->kelas_id,
                'nim' => $request->nim,
            ]);

            DB::commit();
            return $this->success($user, 'Data Mahasiswa berhasil Diubah');
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->error($e);
        }
    }

    public function exportMhs()
    {
        try {
            $data = Mahasiswa::with('user', 'kelas')->whereHas('user', function ($q) {
                $q->where('role_id', 3);
            })->get();

            $pdf = \PDF::loadView('pdf.mahasiswa', ['mahasiswa' => $data]);

            return $pdf->download('mahasiswa.pdf');
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $data =  Mahasiswa::find($id);
            User::where('id', $data->user_id)->delete();
            $data->delete();
            DB::commit();
            return $this->success(null, 'Data Mahasiswa berhasil Dihapus');
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->error($e);
        }
    }


    public function DashboardMhs()
    {
        $user = Auth::user()->id;
        $mhs = Mahasiswa::where("user_id", $user)->first();
        $data = PenugasanMahasiswa::with('penugasan_kelas.penugasan')->where("mahasiswa_id", $mhs->id)->get();

        return $this->success($data);
    }
}
