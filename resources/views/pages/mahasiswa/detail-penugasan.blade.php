@extends('layouts.app')

@section('title')
<div class="d-flex justify-content-between">
    <h4 class="rounded" style="color: #004A8E">Pengerjaan Tugas</h4>
    <div>
        <button class="btn btn-sm btn-secondary btn-back">Back</button> &nbsp;
        <button class="btn btn-sm btn-primary" id="submit-all">Submit All</button>
    </div>
</div>
@endsection
@section('content')
<input type="text" id="penugasan_id" hidden>
<div class="accordion" id="accordion-penugasan">
  </div>
@endsection

@section('script')
  <script>
    var answered = [];
    var indexJwb = [];

    $(document).ready(function () {
        $.ajax({
            url : '/api/mahasiswa/penugasan/' + {{request()->segment(count(request()->segments()))}},
            type: 'GET',
            headers: {
                'Authorization' : 'Bearer ' + Cookies.get('mahasiswa_cookie')
            },
            success: function (data) {
                console.log(data);
                if (data.data.penugasan_mhs.status == 'submitted') {
                    $("#submit-all").attr('hidden', true)
                }
                var idx_exist = 0;
                $('#penugasan_id').val(data.data.penugasan_kelas.id)
                            var soal = JSON.parse(data.data.soal)
                            var jawaban;
                            var jawaban_fix = JSON.parse(data.data.jawaban);
                            jawaban_ksg = JSON.parse(data.data.jawaban_ai)
                            if (data.data.jawaban_mhs.length != 0) {
                                jawaban = data.data.jawaban_mhs
                                jawaban.sort((a, b) => {
                                    return a.soal_id - b.soal_id;
                                });
                            }
                            // console.log("jawaban", jawaban);

                            soal.forEach((el,idx)=> {
                                indexJwb.push(el.split(":")[0]);
                                if (el != " ") {
                                    if (jawaban != undefined) {

                                        if ((jawaban[idx] != null || jawaban[idx] != undefined) ||  (jawaban[idx_exist] != undefined )) {
                                            console.log(jawaban[idx_exist]['soal_id'] , idx + 1);
                                            if ((jawaban[idx_exist]['soal_id'] == idx + 1)) {
                                                var no_soal = jawaban[idx_exist]['soal_id'] - 1;
                                                answered.push(jawaban[idx_exist]['soal_id']);
                                                $('#accordion-penugasan').append(`
                                                <x-accordion idx="${no_soal}" questid="${no_soal + 1}">
                                                    <div class="row d-flex">
                                                        <div class="col-md">
                                                            <h5>Pertanyaan</h5>
                                                            ${el.split(":")[1]}</div>
                                                        <div class="col-md">
                                                            <h5>Jawaban Benar </h5>
                                                            <textarea name="" data-id="${no_soal}" class="form-control " cols="30" rows="5" disabled>${jawaban_fix[idx_exist].split(":")[1]}</textarea>
                                                            </div>

                                                            <div class="col-md">
                                                                <h5>Jawaban Mahasiswa </h5>
                                                                <textarea name="" data-id="${no_soal}" class="form-control jawaban" cols="30" rows="5" disabled>${jawaban[idx_exist]['jawaban']}</textarea>
                                                        </div>

                                                    </div>
                                                    <div class="row d-flex">
                                                        <div class="col-md-6">
                                                            <h5>Komentar</h5>
                                                             <textarea name="" id="" class="form-control" cols="30" rows="10">${jawaban[idx_exist]['komentar']}</textarea>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <h5>Nilai MT</h5>
                                                                <span class="badge badge-pill ${jawaban[idx_exist]['nilai_ai'] >= 70 ? 'badge-success' : 'badge-danger'}">${jawaban[idx_exist]['nilai_ai']}</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <h5>Nilai Dosen</h5>
                                                                <span class="badge badge-pill ${jawaban[idx_exist]['nilai_dosen'] >= 70 ? 'badge-success' : 'badge-danger'}">${jawaban[idx_exist]['nilai_dosen']}</span>
                                                            </div>
                                                        </div>
                                                </x-accordion>`)
                                                idx_exist++;
                                            } else {
                                                $('#accordion-penugasan').append(`
                                                    <x-accordion idx="${idx}" questid="${idx + 1}">
                                                        <div class="row d-flex">
                                                            <div class="col-md">
                                                                <h5>Pertanyaan</h5>
                                                                ${el.split(":")[1]}</div>
                                                            <div class="col-md">
                                                                <h5>Jawaban </h5>
                                                                <textarea name="" data-id="${el.split(":")[0]}" class="form-control jawaban" cols="30" rows="5">${jawaban_ksg[idx].split(":")[1]}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="text-right mt-3">
                                                            <button class="btn btn-sm btn-primary btn-submit-answer" data-id="${idx}">Submit</button>
                                                        </div>

                                                    </x-accordion>`)
                                            }
                                        } else {
                                            $('#accordion-penugasan').append(`
                                            <x-accordion idx="${idx}" questid="${idx + 1}">
                                                <div class="row d-flex">
                                                    <div class="col-md">
                                                        <h5>Pertanyaan</h5>
                                                        ${el.split(":")[1]}</div>
                                                    <div class="col-md">
                                                        <h5>Jawaban </h5>
                                                        <textarea name="" data-id="${el.split(":")[0]}" class="form-control jawaban" cols="30" rows="5">${jawaban_ksg[idx].split(":")[1]}</textarea>
                                                    </div>
                                                </div>
                                                <div class="text-right mt-3">
                                                    <button class="btn btn-sm btn-primary btn-submit-answer" data-id="${idx}">Submit</button>
                                                </div>
                                            </x-accordion>`)
                                        }
                                    }else {
                                            $('#accordion-penugasan').append(`
                                            <x-accordion idx="${idx}" questid="${idx + 1}">
                                                <div class="row d-flex">
                                                    <div class="col-md">
                                                        <h5>Pertanyaan</h5>
                                                        ${el.split(":")[1]}</div>
                                                    <div class="col-md">
                                                        <h5>Jawaban </h5>
                                                        <textarea name="" data-id="${el.split(":")[0]}" class="form-control jawaban" cols="30" rows="5">${jawaban_ksg[idx].split(":")[1]}</textarea>
                                                    </div>
                                                </div>
                                                <div class="text-right mt-3">
                                                    <button class="btn btn-sm btn-primary btn-submit-answer" data-id="${idx}">Submit</button>
                                                </div>
                                            </x-accordion>`)
                                        }
                                }
                                idx++;
                            });
            }
        })
    })

    $('body').on('click', '.btn-submit-answer', function () {
        var id = $(this).data('id');
        // console.log();
        var jawaban = $(this).parent().siblings().find('.jawaban').val();
        var penugasan_kelas_id = $('#penugasan_id').val();
        console.log(id, jawaban, penugasan_kelas_id);
        var form = $(this);
        $.ajax({
            url : '/api/mahasiswa/penugasan/submit/' + id,
            type: 'POST',
            headers : {
                'Authorization':  'Bearer ' + curCookie,
            },
            data : {
                'penugasan_kelas_id' : penugasan_kelas_id,
                'soal_id' : id + 1,
                'jawaban' : jawaban
            },
            success : function (data) {
                $(form).fadeOut(800, function(){
                            form.html(data).fadeIn().delay(2000);

                        });
            }
        })
    })

    $('#submit-all').on('click', function () {
        // console.log(indexJwb);
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda tidak dapat mengubah jawaban setelah mengirimkan jawaban",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Kirim Jawaban!'
          }).then((result) => {
            if (result.isConfirmed) {
                $('#screen-loader').attr("hidden", false)

                var jawabans = [];
                for (let index = 0; index < $('.jawaban').length; index++) {
                    // jawabans.push($('.jawaban')[index].value);
                    var jawab = $('.jawaban')[index].value;
                    jawabans[index] = jawab
                }
                console.log("JAWABAN",jawabans);
                $.ajax({
                    url : '/api/mahasiswa/penugasan/submit-all',
                    type: 'POST',
                    headers : {
                        'Authorization':  'Bearer ' + curCookie,
                    },
                    data : {
                        'penugasan_kelas_id' : $('#penugasan_id').val(),
                        'jawabans' : jawabans,
                        'answered' : answered,
                        'indexJwb' : indexJwb
                    },
                    success : function (data) {
                        console.log(data);
                        alertSuccess("Berhasil mengirimkan jawaban");
                        setTimeout(() => {
                            window.location.href = '/mahasiswa/penugasan';
                        }, 2000);
                        $('#screen-loader').attr("hidden", true)
                        // window.location.href = '../'
                    },
                    error : function (err) {
                        $('#screen-loader').attr("hidden", true)
                        alertError(err.responseJSON.message);

                    }
                })
            }
          })

    })

  </script>
@endsection
