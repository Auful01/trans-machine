<?php

namespace App\Http\Controllers;

use App\Http\Traits\Response;
use App\Models\Mahasiswa;
use App\Models\PenugasanKelas;
use App\Models\PenugasanMahasiswa;
use App\Models\PenugasanMahasiswaJawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenugasanMahasiswaController extends Controller
{
    use Response;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            // ((SELECT COUNT(penugasan_mahasiswa.id) FROM penugasan_mahasiswa INNER JOIN mahasiswa ON mahasiswa.id = penugasan_mahasiswa.mahasiswa_id INNER JOIN kelas ON kelas.id = mahasiswa.kelas_id  WHERE penugasan_mahasiswa.status = 'submitted') / (SELECT COUNT(penugasan_mahasiswa.id) FROM penugasan_mahasiswa INNER JOIN mahasiswa ON mahasiswa.id = penugasan_mahasiswa.mahasiswa_id INNER JOIN kelas ON kelas.id = mahasiswa.kelas_id  WHERE penugasan_mahasiswa.status = 'submitted') * 100) as presentase
            // dd($request->id);
            // $data = DB::select("SELECT kelas.name as nama_kelas, kelas.id as id_kelas, (SELECT COUNT(penugasan_mahasiswa.id) FROM penugasan_mahasiswa INNER JOIN mahasiswa ON mahasiswa.id = penugasan_mahasiswa.mahasiswa_id INNER JOIN kelas ON kelas.id = mahasiswa.kelas_id  WHERE penugasan_mahasiswa.status = 'submitted') as submitted, (SELECT COUNT(penugasan_mahasiswa.id) FROM penugasan_mahasiswa INNER JOIN mahasiswa ON mahasiswa.id = penugasan_mahasiswa.mahasiswa_id INNER JOIN kelas ON kelas.id = mahasiswa.kelas_id  WHERE penugasan_mahasiswa.status <> 'submitted') as unsubmitted FROM penugasan_mahasiswa INNER JOIN mahasiswa ON mahasiswa.id = penugasan_mahasiswa.mahasiswa_id INNER JOIN kelas ON kelas.id = mahasiswa.kelas_id  WHERE penugasan_mahasiswa.penugasan_id = " . (int)$request->id . "  GROUP BY nama_kelas, id_kelas ");
            $data = DB::select('SELECT users.name as nama, mahasiswa.nim as nim FROM mahasiswa LEFT JOIN users ON users.id = mahasiswa.user_id LEFT JOIN  penugasan_mahasiswa ON mahasiswa.id = penugasan_mahasiswa.mahasiswa_id LEFT JOIN penugasan_kelas ON penugasan_kelas.id = penugasan_mahasiswa.penugasan_kelas_id');
            dd($data);
            return $this->success($data);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->error($th->getMessage());
        }
    }

    public function myTugas()
    {
        try {
            $user = Auth::user()->id;
            $data = DB::select('SELECT penugasan_mahasiswa.penugasan_kelas_id as id, penugasan.judul as judul, penugasan.deskripsi as deskripsi, penugasan_kelas.tanggal_selesai as tanggal_selesai, penugasan_mahasiswa.status as status  FROM penugasan_mahasiswa  INNER JOIN penugasan_kelas ON penugasan_mahasiswa.penugasan_kelas_id = penugasan_kelas.id  INNER JOIN mahasiswa ON mahasiswa.id = penugasan_mahasiswa.mahasiswa_id  INNER JOIN penugasan ON penugasan.id = penugasan_kelas.penugasan_id  WHERE mahasiswa.user_id = ' . $user . ' GROUP BY id');
            // if ($data == null) {
            //     $data = DB::select('SELECT penugasan.id as id,  penugasan.judul as judul, penugasan.deskripsi as deskripsi, penugasan_kelas.tanggal_selesai as tanggal_selesai, penugasan_mahasiswa.status as status FROM penugasan LEFT JOIN penugasan_kelas ON penugasan_kelas.penugasan_id = penugasan.id  LEFT JOIN mahasiswa ON mahasiswa.kelas_id = penugasan_kelas.kelas_id LEFT JOIN penugasan_mahasiswa ON penugasan_mahasiswa.mahasiswa_id = mahasiswa.id GROUP BY judul');
            //     # code...
            // }
            // $data = PenugasanKelas::with('penugasan')->get();
            // dd($data);
            return $this->success($data);
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
            $mhs = Mahasiswa::where('kelas_id', $request->kelas_id)->get();

            if (count($mhs) < 1) {
                return $this->error('Belum ada data mahasiswa');
            }

            foreach ($mhs as $key => $value) {
                # code...
                if ($value->kelas_id == $request->kelas_id) {
                    # code...
                    PenugasanMahasiswa::create([
                        'penugasan_id' => $request->penugasan_id,
                        'mahasiswa_id' => $value->id,
                        'tanggal_mulai' => $request->tanggal_mulai,
                        'tanggal_selesai' => $request->tanggal_selesai
                    ]);
                }
            }

            DB::commit();

            return $this->success(null, 'Sukses');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->error($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PenugasanMahasiswa  $penugasanMahasiswa
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // dd($id);
        $data = DB::select("SELECT penugasan.id as id, penugasan.soal as soal, penugasan.jawaban as jawaban, penugasan_mahasiswa.is_review as is_review, penugasan_mahasiswa.total_nilai as nilai, penugasan_mahasiswa.status as status_pengumpulan FROM penugasan_mahasiswa
                            INNER JOIN penugasan_kelas ON penugasan_mahasiswa.penugasan_kelas_id = penugasan_kelas.id
                            INNER JOIN penugasan ON penugasan_kelas.penugasan_id = penugasan.id
                            -- LEFT JOIN penugasan_mahasiswa ON penugasan_mahasiswa.penugasan_kelas_id = penugasan_kelas.id
                            INNER JOIN penugasan_mahasiswa_jawaban ON penugasan_mahasiswa_jawaban.penugasan_mahasiswa_id = penugasan_mahasiswa.id
                            WHERE penugasan_kelas.id = $id AND penugasan_mahasiswa.mahasiswa_id = $request->mhs_id LIMIT 1");


        $penugasan_mahasiswa = PenugasanMahasiswa::where('mahasiswa_id', $request->mhs_id)->where('penugasan_kelas_id', $id)->first();

        $jawaban_mhs = PenugasanMahasiswaJawaban::where('penugasan_mahasiswa_id', $penugasan_mahasiswa->id)->where('penugasan_mahasiswa_id', $penugasan_mahasiswa->id)->get();
        // dd($data);
        // $jawaban_mhs
        $data[0]->jawaban_mahasiswa = $jawaban_mhs;
        return $this->success($data[0]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PenugasanMahasiswa  $penugasanMahasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(PenugasanMahasiswa $penugasanMahasiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PenugasanMahasiswa  $penugasanMahasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PenugasanMahasiswa $penugasanMahasiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PenugasanMahasiswa  $penugasanMahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(PenugasanMahasiswa $penugasanMahasiswa)
    {
        //
    }


    public function getLaporan()
    {
        $user = Auth::user()->id;
        $mahasiswa = Mahasiswa::where('user_id', $user)->first();

        // $data = DB::select("SELECT penugasan.id as id, penugasan.judul as judul, penugasan.deskripsi as deskripsi, penugasan_kelas.tanggal_selesai as tanggal_selesai, penugasan_mahasiswa.status as status, SUM(penugasan_mahasiswa_jawaban.nilai_ai)/COUNT(penugasan_mahasiswa_jawaban.nilai_ai) as nilai FROM penugasan
        //                     INNER JOIN penugasan_kelas ON penugasan_kelas.penugasan_id = penugasan.id
        //                     INNER JOIN mahasiswa ON mahasiswa.kelas_id = penugasan_kelas.kelas_id
        //                     INNER JOIN penugasan_mahasiswa ON penugasan_mahasiswa.mahasiswa_id = mahasiswa.id
        //                     INNER JOIN penugasan_mahasiswa_jawaban ON penugasan_mahasiswa_jawaban.penugasan_mahasiswa_id = penugasan_mahasiswa.id
        //                     WHERE mahasiswa.user_id = $user GROUP BY judul, penugasan.id");
        $data = PenugasanMahasiswa::with('penugasan_kelas.penugasan')->where('mahasiswa_id', $mahasiswa->id)->get();

        return $this->success($data);
    }
}
