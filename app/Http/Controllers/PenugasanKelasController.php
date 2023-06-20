<?php

namespace App\Http\Controllers;

use App\Http\Traits\Response;
use App\Models\Mahasiswa;
use App\Models\PenugasanKelas;
use App\Models\PenugasanMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenugasanKelasController extends Controller
{
    use Response;
    public function index(Request $request)
    {
        // $data = PenugasanKelas::with('kelas')->where('penugasan_id', $request->id)->get();
        // dd($request->id);
        $data = $data = DB::select("SELECT penugasan_kelas.id as id, kelas.name as name, penugasan.id as penugasan_id, penugasan_kelas.id as penugasan_kelas_id

        FROM penugasan_kelas
        LEFT JOIN penugasan_mahasiswa ON penugasan_mahasiswa.penugasan_kelas_id = penugasan_kelas.id
        INNER JOIN kelas ON kelas.id = penugasan_kelas.kelas_id
        INNER JOIN penugasan ON penugasan.id = penugasan_kelas.penugasan_id
        WHERE penugasan_kelas.penugasan_id = $request->id
        GROUP BY id
        ");

        $kelas = PenugasanKelas::where("penugasan_id", $request->id)->get();
        $dataRet = [];
        foreach ($kelas as $key => $value) {
            # code...
            $dataSubmitted = DB::select("SELECT COUNT('penugasan_mahasiswa.status') as submitted FROM penugasan_mahasiswa INNER JOIN penugasan_kelas ON penugasan_kelas.id = penugasan_mahasiswa.penugasan_kelas_id WHERE penugasan_kelas.id = $value->id AND penugasan_mahasiswa.status = 'submitted'");
            $dataUnsubmitted = DB::select("SELECT COUNT('penugasan_mahasiswa.status') as unsubmitted FROM penugasan_mahasiswa INNER JOIN penugasan_kelas ON penugasan_kelas.id = penugasan_mahasiswa.penugasan_kelas_id WHERE penugasan_kelas.id = $value->id AND penugasan_mahasiswa.status = 'unsubmitted' ");
            $dataRet[$key] = [
                "id" => $value->id,
                "submitted" => $dataSubmitted[0]->submitted,
                "unsubmitted" => $dataUnsubmitted[0]->unsubmitted
            ];
        }

        $resReturn = [];

        foreach ($dataRet as $key => $value) {
            # code...

            if ($data[$key]->penugasan_kelas_id == $value['id']) {


                array_push(
                    $resReturn,
                    [
                        "id" => $data[$key]->id,
                        "name" => $data[$key]->name,
                        "penugasan_id" => $data[$key]->penugasan_id,
                        "submitted" => $value['submitted'],
                        "unsubmitted" => $value['unsubmitted']
                    ]
                );
            }
        }
        // $data[""]
        return $this->success($resReturn);
    }

    public function show($id)
    {
        // dd($id);
        $data = DB::select("SELECT users.id as id, users.name as name, mahasiswa.id as mahasiswa_id, penugasan_mahasiswa.is_review as is_review, mahasiswa.nim as nim, penugasan_mahasiswa.status as status, penugasan.id as penugasan_id, penugasan_mahasiswa.total_nilai as nilai, penugasan_kelas.id as penugasan_kelas_id, (SELECT COUNT('penugasan_mahasiswa.status') FROM penugasan_mahasiswa LEFT JOIN penugasan_kelas ON penugasan_kelas.id = penugasan_mahasiswa.penugasan_kelas_id WHERE penugasan_kelas.penugasan_id = $id AND penugasan_mahasiswa.status = 'submitted') as submitted FROM penugasan_mahasiswa
                            INNER JOIN mahasiswa ON penugasan_mahasiswa.mahasiswa_id = mahasiswa.id
                            INNER JOIN kelas ON kelas.id = mahasiswa.kelas_id
                            INNER JOIN penugasan_kelas ON penugasan_mahasiswa.penugasan_kelas_id = penugasan_kelas.id
                            INNER JOIN penugasan ON penugasan.id = penugasan_kelas.penugasan_id
                            INNER JOIN users ON users.id = mahasiswa.user_id
                            WHERE penugasan_kelas.id = " . $id . " GROUP BY id,penugasan_kelas_id");

        return $this->success($data);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $request['created_by'] = Auth::user()->id;
            foreach ($request['kelas_id'] as $key => $value) {
                # code...
                $data = PenugasanKelas::create([
                    'penugasan_id' => $request->penugasan_id,
                    'kelas_id' => $value,
                    'tanggal_mulai' => $request->tanggal_mulai,
                    'tanggal_selesai' => $request->tanggal_selesai,
                    'created_by' => $request->created_by
                ]);

                $datamhs = Mahasiswa::where('kelas_id', $request->kelas_id)->get();
                foreach ($datamhs as $key => $value) {
                    PenugasanMahasiswa::create([
                        'penugasan_kelas_id' => $data->id,
                        'mahasiswa_id' => $value->id,
                        'status' => 'unsubmitted'
                    ]);
                }
            }
            // $data = PenugasanKelas::create($request->all());


            DB::commit();

            return $this->success($data);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->error($th->getMessage());
        }
    }
}
