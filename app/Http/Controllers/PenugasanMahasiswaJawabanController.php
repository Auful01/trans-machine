<?php

namespace App\Http\Controllers;

use App\Http\Traits\Response;
use App\Models\Mahasiswa;
use App\Models\Penugasan;
use App\Models\PenugasanKelas;
use App\Models\PenugasanMahasiswa;
use App\Models\PenugasanMahasiswaJawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class PenugasanMahasiswaJawabanController extends Controller
{
    use Response;

    public function submit(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $updt = PenugasanMahasiswa::where('mahasiswa_id',  Mahasiswa::where('user_id', Auth::user()->id)->first()->id)->where('penugasan_kelas_id', $request->penugasan_kelas_id);

            $png_kelas = PenugasanKelas::find($request->penugasan_kelas_id);
            $jawaban = Penugasan::find($png_kelas->penugasan_id)->jawaban;
            $arrJawaban = json_decode($jawaban);

            similar_text($request->jawaban, $arrJawaban[$id], $sim);
            // dd($id);
            $jawab = [
                'jawaban' => $request->jawaban,
                'jawaban_benar' => $arrJawaban[$id],
            ];
            $jwb_mhs = $request->jawaban;
            // dd($jwb_mhs);
            $jwb_bnr = explode(":", $arrJawaban[$id]);
            dd($jwb_bnr);
            $jawab = $jwb_mhs . ";" . $jwb_bnr[$id];
            dd($jawab);


            // $jawab = json_encode($jawab);
            // dd($jawab);
            $test = Process::fromShellCommandline('python3 -c "$(wget -q -O - ' . asset('storage/python/cosine_similarity.py') . ')" ' . $jawab);
            $test->run();
            if (!$test->isSuccessful()) {
                throw new ProcessFailedException($test);
            }

            $nilai_ai = $test->getOutput();
            dd($nilai_ai);
            dd(($updt->total_nilai + number_format(floatval($nilai_ai) * 100, 2, '.', ' ') / count($arrJawaban)));
            // dd($request->jawaban);

            $data = PenugasanMahasiswaJawaban::create([
                'penugasan_mahasiswa_id' => $updt->first()->id,
                'soal_id' => $request->soal_id,
                'jawaban' => $request->jawaban,
                'nilai_ai' => number_format(floatval($nilai_ai) * 100, 2, '.', ' '),
                'nilai_dosen' => number_format(floatval($nilai_ai) * 100, 2, '.', ' ')
            ]);

            $updt->update([
                "total_nilai" => ($updt->total_nilai + number_format(floatval($nilai_ai) * 100, 2, '.', ' ') / count($arrJawaban))
            ]);
            // dd($data);
            DB::commit();
            return $this->success($data, "Jawaban Berhasil Disimpan");
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->error($th->getMessage());
        }
    }

    public function review(Request $request)
    {
        try {
            //code...
            DB::beginTransaction();
            $data = PenugasanMahasiswa::where('penugasan_kelas_id', $request->kelas_id)->where('mahasiswa_id', $request->mahasiswa_id)->first();
            $old = PenugasanMahasiswaJawaban::where("penugasan_mahasiswa_id", $data->id)->where('id', $request->id)->first();
            PenugasanMahasiswaJawaban::where("penugasan_mahasiswa_id", $data->id)->where('soal_id', $request->id)->update([
                "nilai_dosen" => $request->nilai ?? $old->nilai_ai,
                "komentar" => $request->komentar,
                "is_review" => 1
            ]);

            DB::commit();

            return $this->success($data);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->error($th->getMessage());
        }        // dd($data);
    }

    public function reviewAll(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $total = 0;
            $len = 1;
            $data = PenugasanMahasiswa::where('penugasan_kelas_id', $request->kelas_id)->where('mahasiswa_id', $request->mahasiswa_id)->first();
            foreach ($request->data as $key => $value) {
                $old = PenugasanMahasiswaJawaban::where("penugasan_mahasiswa_id", $data->id)->where('soal_id', $value['id_soal'])->first();
                # code...
                // dd($value);
                PenugasanMahasiswaJawaban::where("penugasan_mahasiswa_id", $data->id)->where('soal_id', $value['id_soal'])->update([
                    "nilai_dosen" => $value['nilai'] ?? $old['nilai_ai'],
                    "komentar" => $value['komentar'],
                    "is_review" => 1
                ]);
                $total += $value->nilai ?? $old['nilai_ai'];
                $len++;
            }

            PenugasanMahasiswa::where('penugasan_kelas_id', $request->kelas_id)->where('mahasiswa_id', $request->mahasiswa_id)->update([
                "is_review" => 1,
                "total_nilai" => $total / $len
            ]);

            // dd(PenugasanMahasiswaJawaban::where("penugasan_mahasiswa_id", $data->id)->get());

            DB::commit();
            return $this->success($data);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->error($th->getMessage());
        }
    }

    public function submitAll(Request $request)
    {
        try {
            DB::beginTransaction();
            $updt = PenugasanMahasiswa::where('mahasiswa_id',  Mahasiswa::where('user_id', Auth::user()->id)->first()->id)->where('penugasan_kelas_id', $request->penugasan_kelas_id);
            $data = $updt->update([
                'status' => 'submitted',
                'waktu_mulai' => now(),
                'waktu_selesai' => now(),
            ]);

            $totalNilai = 0;
            $png_kelas = PenugasanKelas::find($request->penugasan_kelas_id);
            $jawaban = Penugasan::find($png_kelas->penugasan_id)->jawaban;
            $arrJawaban = json_decode($jawaban);

            // dd($request->answered);
            if ($request->answered == null) {
                # code...

                foreach ($request->indexJwb as $key => $value) {

                    if ($arrJawaban[$key] != null && $arrJawaban[$key] != "\n") {
                        # code...
                        $jwbArr = explode(":", $arrJawaban[$key])[1];
                        $jawab = [
                            'jawaban' => $request["jawabans"][$key],
                            'jawaban_benar' => $jwbArr,
                        ];



                        $jawab = json_encode($jawab);
                        $test = new Process(['python3', 'Python/cosine_similarity.py', $jawab]);
                        $test->run();
                        if (!$test->isSuccessful()) {
                            throw new ProcessFailedException($test);
                        }

                        $nilai_ai = $test->getOutput();

                        $totalNilai += floatval($nilai_ai) * 100;

                        // dd($totalNilai);
                        $data = PenugasanMahasiswaJawaban::create([
                            'penugasan_mahasiswa_id' => $updt->first()->id,
                            'soal_id' => $value + 1,
                            'jawaban' => $request["jawabans"][$key],
                            'nilai_ai' => number_format(floatval($nilai_ai) * 100, 2, '.', ' '),
                            'nilai_dosen' => number_format(floatval($nilai_ai) * 100, 2, '.', ' ')
                        ]);
                    }
                    # code...

                }
            } else {
                foreach ($request->indexJwb as $key => $value) {
                    // dd($arrJawaban[32] == "\n");
                    $test = $updt->first()->id;
                    $ansSel = DB::select("SELECT soal_id  as soal_id FROM penugasan_mahasiswa_jawaban WHERE penugasan_mahasiswa_id = " . $test);
                    $ans = array_column($ansSel, "soal_id");
                    // dd($value);
                    if (!in_array($value + 1, $ans)) {
                        $jwbArr = explode(":", $arrJawaban[$key])[1];
                        if ($arrJawaban[$key] != null && $arrJawaban[$key] != "\n") {
                            # code...
                            $jawab = [
                                'jawaban' => $request["jawabans"][$key],
                                'jawaban_benar' => $jwbArr,
                            ];

                            // dd($jwbArr);
                            $jawab = json_encode($jawab);
                            $test = new Process(['python3', 'Python/cosine_similarity.py', $jawab]);
                            $test->run();
                            if (!$test->isSuccessful()) {
                                throw new ProcessFailedException($test);
                            }

                            $nilai_ai = $test->getOutput();
                            // dd($nilai_ai);

                            $updt->update([
                                "total_nilai" => ($updt->total_nilai + number_format(floatval($nilai_ai) * 100, 2, '.', ' ') / count($arrJawaban))
                            ]);

                            $data = PenugasanMahasiswaJawaban::create([
                                'penugasan_mahasiswa_id' => $updt->first()->id,
                                'soal_id' => $value + 1,
                                'jawaban' => $request["jawabans"][$key],
                                'nilai_ai' => number_format(floatval($nilai_ai) * 100, 2, '.', ' '),
                                'nilai_dosen' => number_format(floatval($nilai_ai) * 100, 2, '.', ' ')
                            ]);
                        }
                        # code...

                    }
                }
            }


            $updt->update([
                "total_nilai" => $totalNilai / count($arrJawaban)
            ]);
            DB::commit();

            return $this->success($data, "Jawaban Berhasil Disimpan");
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->error($th->getMessage());
        }
    }
}
