<?php

namespace App\Http\Controllers;

use App\Http\Traits\Response;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\Penugasan;
use App\Models\PenugasanKelas;
use App\Models\PenugasanMahasiswa;
use App\Models\PenugasanMahasiswaJawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
// use Sastrawi\SentenceDetector\SentenceDetectorFactory();

class PenugasanController extends Controller
{
    use Response;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexPenugasanMhs()
    {
        $data = Penugasan::all();
        return $this->success($data);
    }

    public function index()
    {
        try {
            // $data = PenugasanMahasiswa::with('penugasan')->where('mahasiswa_id', '=', '3')->get();
            $data = Penugasan::all();
            return $this->success($data);
        } catch (\Throwable $th) {
            //throw $th;
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

            if ($request->file('file_asal')) {
                $filename_asal = $request->file('file_asal')->getClientOriginalName();
                $request->file('file_asal')->storeAs('/asal', $filename_asal, 'public');
            }

            if ($request->file('file_hasil')) {
                $filename_hasil = $request->file('file_hasil')->getClientOriginalName();
                $request->file('file_hasil')->storeAs('/hasil', $filename_hasil, 'public');
                # code...
            }

            ini_set('memory_limit', '-1');
            // $soal_slice = new Process(['python3', File::get(asset('python/convert2txt.py')), asset('storage/asal') . '/' . $filename_asal]);
            // $soal_slice->run();
            // ini_get('allow_url_fopen');
            // ini_set('allow_url_fopen', 1);
            $file = asset('storage/asal') . '/' . $filename_asal;
            // dd(fopen($file, 'r'));
            //
            $soal_slice = Process::fromShellCommandline('python3 -c "$(wget -q -O - ' . asset('storage/python/convert2txt.py') . ')" ' . $file);
            $soal_slice->run();

            if (!$soal_slice->isSuccessful()) {
                throw new ProcessFailedException($soal_slice);
            }
            dd($soal_slice->getOutput());

            $jawaban_slice = new Process(['python3', File::get(asset('python/jawaban_slice.py')), asset('storage/hasil') . '/' . $filename_hasil]);
            $jawaban_slice->run();


            if (!$jawaban_slice->isSuccessful()) {
                throw new ProcessFailedException($jawaban_slice);
            }

            // $py = file_get_contents(asset('python/test.py'));
            // // dd($py);

            // // $soal_slice = new Process(['python3',asset('python/test.py'), asset('storage/asal') . '/'. $filename_asal]);
            // // $soal_slice->run();
            // // $file = Storage::disk('public')->download('python', 'test.py');
            // $file = file_get_contents(asset('python/test.py'));

            // $soal_slice = new Process(['python3', asset('python/test.py')  , asset('storage/asal') . '/'. $filename_asal]);
            // // $content = file_get_contents(asset("storage/asal" . "/". $filename_asal));
            // // dd($content);
            // $soal_slice = Process::fromShellCommandline('python3 -c "$(wget -q -O - '. asset('storage/python/convert2txt.py') . ') " ');
            // $soal_slice->run();

            // // $jawaban_slice = new Process(['python3', "$(wget -q -O - ". asset('storage/python/jawaban_slice.py') . " )", asset('storage/hasil'). '/'. $filename_hasil]);
            // // $jawaban_slice->run();

            // // dd($file);
            if (!$soal_slice->isSuccessful()) {
                throw new ProcessFailedException($soal_slice);
            }
            $soalOutput = $soal_slice->getOutput();
            // dd($soalOutput);
            if (!$soal_slice->isSuccessful()) {
                throw new ProcessFailedException($soal_slice);
            }

            if (!$jawaban_slice->isSuccessful()) {
                throw new ProcessFailedException($jawaban_slice);
            }

            $soalOutput = $soal_slice->getOutput();
            $jawabOutput = $jawaban_slice->getOutput();

            $soal_asal = explode("\n", $soalOutput);

            $soal  = json_encode(explode(";", $soal_asal[0]));
            $jawaban_ai = json_encode(explode(";", $soal_asal[1]));
            $jawab  = json_encode(explode(";", $jawabOutput));
            // dd($jawab);

            // dd($jawab);
            $data = Penugasan::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'file_asal' => $filename_asal,
                'file_hasil' => $filename_hasil,
                'soal' => $soal,
                'jawaban_ai' => $jawaban_ai,
                'jawaban' => $jawab
            ]);

            DB::commit();

            return $this->success($data, 'Data Sukses Disimpan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penugasan  $penugasan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tugas = Penugasan::find($id);
        $kelas = PenugasanKelas::where('penugasan_id', $id)->get();
        // $kelas = [];
        // foreach ($tugas_mhs as $key => $value) {
        //     $data = Kelas::find($value['mahasiswa']['kelas_id']);
        //     if (!in_array($data, $kelas)) {
        //         array_push($kelas, $data);
        //     }
        // }
        // dd($kelas);
        return view('pages.admin.detail-penugasan', ["tugas" => $tugas, "kelas" => $kelas]);
    }

    public function penugasanDetail($id)
    {
        try {
            $tugas = Penugasan::find($id);


            return $this->success($tugas);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->error($th->getMessage());
        }
    }

    public function doNow($id)
    {
        $mhs = Mahasiswa::where('user_id', Auth::user()->id)->first();
        $penugasan_kelas = PenugasanKelas::where('id', $id)->where('kelas_id', $mhs->kelas_id)->first();
        $data = Penugasan::find($penugasan_kelas->penugasan_id);
        // dd($penuga);
        $penugasan_mhs = PenugasanMahasiswa::where('penugasan_kelas_id', $penugasan_kelas->id)->where('mahasiswa_id', $mhs->id)->first();
        $jawaban_mhs = PenugasanMahasiswaJawaban::where('penugasan_mahasiswa_id', $penugasan_mhs->id)->get();
        $data['penugasan_kelas'] = $penugasan_kelas;
        $data['penugasan_mhs'] = $penugasan_mhs;
        $data['jawaban_mhs'] = $jawaban_mhs;


        return $this->success($data, 'Data Sukses diambil');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penugasan  $penugasan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penugasan $penugasan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penugasan  $penugasan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Penugasan::find($id);

            $filename_asal = $data->file_asal;
            if ($request->file('file_asal') != null) {
                $filename_asal = $request->file('file_asal')->getClientOriginalName();
                $request->file('file_asal')->storeAs('/asal', $filename_asal, 'public');
            }

            $filename_hasil = $data->file_hasil;
            if ($request->file('file_hasil') != null) {
                $filename_hasil = $request->file('file_hasil')->getClientOriginalName();
                $request->file('file_hasil')->storeAs('/hasil', $filename_hasil, 'public');
                # code...
            }


            if ($filename_asal != $data->file_asal) {
                # code...
                $soal_slice = new Process(['python3', 'Python/convert2txt.py', $filename_asal]);
                $soal_slice->run();

                if (!$soal_slice->isSuccessful()) {
                    throw new ProcessFailedException($soal_slice);
                }
                $soalOutput = $soal_slice->getOutput();
                $soal  = json_encode(explode(";", $soalOutput));
            }

            if ($filename_hasil != $data->file_hasil) {
                # code...
                $jawaban_slice = new Process(['python3', 'Python/jawaban_slice.py', $filename_hasil]);
                $jawaban_slice->run();

                if (!$jawaban_slice->isSuccessful()) {
                    throw new ProcessFailedException($jawaban_slice);
                }
                $jawabOutput = $jawaban_slice->getOutput();

                $jawab  = json_encode(explode(";", $jawabOutput));
            }



            $data->update([
                'judul' => $request->judul ?? $data->judul,
                'deskripsi' => $request->deskripsi ?? $data->deskripsi,
                'file_asal' => $filename_asal ?? $data->file_asal,
                'file_hasil' => $filename_hasil ?? $data->file_hasil,
                'soal' => $soal ?? $data->soal,
                'jawaban' => $jawab ?? $data->jawaban
            ]);
            // $data->update([
            //     'judul' => $request->judul,
            //     'deskripsi' => $request->deskripsi,
            // ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penugasan  $penugasan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Penugasan::find($id);
        $relation = PenugasanKelas::where('penugasan_id', $data->id)->first();
        // $penugasan_mhs = PenugasanMahasiswa::where("penugasan_kelas_id", $relation->id)->get();
        // dd($relation->id);
        if ($relation != null) {
            return $this->error("Tidak bisa dihapus karena sudah memiliki data");
        } else {
            $data->delete();
            return $this->success($data);
        }
    }


    public function multiexplode($delimiters, $string)
    {
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }
}
