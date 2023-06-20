@extends('layouts.app')

@section('title')
<div class="d-flex justify-content-between">
<h4 class="rounded" style="color: #004A8E">Detail Pengerjaan Tugas</h4>
<div>

    {{-- <button class="btn btn-sm btn-secondary btn-back" >Back</button> --}}
    <a href="" class="btn btn-sm btn-secondary" id="btn-kembali">Back</a>
    <button class="btn btn-sm btn-primary" id="btn-review-penugasan">Review</button>
</div>
</div>
@endsection
@section('content')
<div class="accordion" id="accordion-penugasan">

    {{-- <div class="card">
      <div class="card-header" id="headingTwo">
        <h2 class="mb-0">
          <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            Collapsible Group Item #2
          </button>
        </h2>
      </div>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
        <div class="card-body">
          Some placeholder content for the second accordion panel. This panel is hidden by default.
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header" id="headingThree">
        <h2 class="mb-0">
          <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            Collapsible Group Item #3
          </button>
        </h2>
      </div>
      <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
        <div class="card-body">
          And lastly, the placeholder content for the third and final accordion panel. This panel is hidden by default.
        </div>
      </div>
    </div> --}}
  </div>
@endsection

@section('script')
  <script>
    $(document).ready(function () {
        $('#btn-kembali').attr("href", window.location.origin + "/admin/penugasan/kelas/" + localStorage.getItem("lts"))
        var urlParams = new URLSearchParams(window.location.search);
        // console.log(urlParams.get('mhs_id'));
        $.ajax({
            url : '/api/penugasan/mahasiswa/detail/' + {{request()->segment(count(request()->segments()))}},
            type: 'GET',
            data : {
                mhs_id : getUrlParam('mhs_id')
            },
            success: function (data) {
                console.log(data);
                        if (data.data.status_pengumpulan == 'unsubmitted' ) {
                            $('#btn-review-penugasan').attr('disabled', true)
                        }

                        if (data.data.is_review == 1) {
                            $('#btn-review-penugasan').attr("disabled", true);
                        }
                            var soal = JSON.parse(data.data.soal)
                            var jawaban = JSON.parse(data.data.jawaban)
                            var jawaban_mahasiswa = data.data.jawaban_mahasiswa
                            console.log(jawaban_mahasiswa);
                            var id = 0;
                            soal.forEach((el,idx)=> {
                                if (el != " ") {
                                    $('#accordion-penugasan').append(`
                                    <x-accordion idx="${idx}" questid="${id + 1}">
                                        <div class="row d-flex mb-4">
                                            <div class="col-md">
                                                <h5>Pertanyaan</h5>
                                                ${el.split(":")[1]}</div>
                                            <div class="col-md">
                                                <h5>Jawaban Asal</h5>
                                                <textarea name="" id="" class="form-control" cols="30" rows="5">${jawaban[idx].split(":")[1]}</textarea>
                                            </div>
                                            <div class="col-md">
                                                <h5>Jawaban Peserta</h5>
                                                <textarea name="" id="" class="form-control" cols="30" rows="5" disabled>${jawaban_mahasiswa.length > 0 ? jawaban_mahasiswa[idx]['jawaban'] : ''}</textarea>
                                            </div>

                                        </div>
                                        <div class="row d-flex ">
                                            <div class="col-md nilai-span">
                                                    <h5>Nilai Otomatis</h5>
                                                    <span data-id=${idx} class="badge-nilai badge badge-pill ${jawaban_mahasiswa.length == 0 ? 'badge-secondary' : jawaban_mahasiswa[idx]['nilai_ai'] >= 70 ? 'badge-success' : 'badge-danger'}">${jawaban_mahasiswa.length > 0 ? jawaban_mahasiswa[idx]['nilai_ai'] : 0}</span>

                                                    </div>
                                                    <div class="col-md">
                                                        <h5>Nilai Dosen</h5>
                                                    <span data-id=${idx} ${jawaban_mahasiswa[idx]['is_review'] != 0 ? "" : "hidden"} class="badge-nilai badge badge-pill ${jawaban_mahasiswa.length == 0 ? 'badge-secondary' : jawaban_mahasiswa[idx]['nilai_dosen'] >= 70 ? 'badge-success' : 'badge-danger'}">${jawaban_mahasiswa.length > 0 ? jawaban_mahasiswa[idx]['nilai_dosen'] : 0}</span>
                                                    <input type="text" ${jawaban_mahasiswa[idx]['is_review'] == 0 ? "" : "hidden"}  id="form-nilai-${idx}" value=${jawaban_mahasiswa[idx]['nilai_dosen']} class="form-control form-control-sm form-nilai" />
                                                </div>
                                                <div class="col-md">
                                                    <h5>Tanggal Pengumpulan</h5>
                                                    <div>
                                                            <td >${jawaban_mahasiswa.length > 0 ? convertDate(jawaban_mahasiswa[idx]['created_at']) : ''}</td>
                                                    </div>
                                                </div>
                                                <div class="col-md">
                                                    <h5>Komentar</h5>
                                                    <textarea name="" id="" ${jawaban_mahasiswa[idx]['is_review'] == 1 ? 'disabled' : ""} class="form-control form-komentar" cols="30" rows="5">${jawaban_mahasiswa[idx]['komentar']}</textarea>
                                                </div>
                                            </div>
                                            <div class="text-right mt-3" ${data.data.is_review == 1 ? 'hidden' : ''}>
                                                <button class="btn btn-sm btn-primary btn-review-answer" data-id="${idx}">Review</button>
                                            </div>
                                    </x-accordion>`)
                                }
                                id++;
                            });
            }
        })
    })

    $("body").on("dblclick",".badge-nilai",function(){
        var id = $(this).data('id')
        console.log("Test");
        var nilai = $(this).text()
        $(this).hide()
        $(`#form-nilai-${id}`).attr('hidden',false).val(nilai).focus()
    })


    $('body').on('keyup', '.nilai-span',function(e){
        if (e.keyCode == 13) {
            $(this).find('.badge-nilai').text($(this).find('input').val())
            $(this).find('.badge-nilai').show()
            console.log("Test Close");
            $(this).find('input').attr('hidden',true)
        }
    });


    $('body').on('click', '.btn-review-answer', function () {
        var nilai = $(this).parent().siblings().closest('.row').find(".form-nilai").closest('.form-nilai').val();
        var komentar = $(this).parent().siblings().closest('.row').find(".form-komentar").closest('.form-komentar').val()
        var id = $(this).data('id')
        var kelas = window.location.pathname.split("/")
        var kelas_id = kelas[kelas.length - 1]
        console.log(kelas_id);
        var form = $(this)
        $.ajax({
            url : '/api/penugasan/review',
            type : "POST",
            data : {
                id : id,
                kelas_id : kelas_id,
                mahasiswa_id: getUrlParam('mhs_id'),
                nilai : nilai,
                komentar :komentar
            },
            success : function (data) {
                $(form).fadeOut(800, function(){
                            form.html('Reviewed').attr("disabled",true).fadeIn().delay(2000);
                        });
            }
        })
        // console.log();
    })

    $('#btn-review-penugasan').on('click', function () {
        var review = [];

        for (let index = 0; index < $(".form-nilai").length; index++) {
            // const element = array[index];
            // console.log($(".")[index].value);

            review[index] = {
                "id_soal" : index + 1,
                "nilai_dosen" : $(".form-nilai")[index].value,
                "komentar" : $(".form-komentar")[index].value
            }
        }
        var nilai = $(this).parent().siblings().closest('.row').find(".form-nilai").closest('.form-nilai').val();
        var komentar = $(this).parent().siblings().closest('.row').find(".form-komentar").closest('.form-komentar').val()
        // var id = $(this).data('id')
        var kelas = window.location.pathname.split("/")
        var kelas_id = kelas[kelas.length - 1]

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda tidak dapat mengubah nilai setelah mengirimkan nilai",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Review Nilai!'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url : '/api/penugasan/review-all',
                    type : "POST",
                    data : {
                        // id : id,
                        kelas_id : kelas_id,
                        mahasiswa_id: getUrlParam('mhs_id'),
                        data : review
                    },
                    success : function (data) {
                        alertSuccess("Sukses di review")
                        // setTimeout(() => {
                        //     window.location.href = window.location.origin + "/admin/penugasan/kelas/" + kelas_id
                        // }, 2000);
                    }
                })
            }
        })
        // console.log(review);
        // .forEach(element => {

        // });
    })

    $(window).on('beforeunload', function(){
        return 'Are you sure you want to leave?';
    });

  </script>
@endsection
