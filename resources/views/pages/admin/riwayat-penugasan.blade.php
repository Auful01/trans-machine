@extends('layouts.app')

@section('title')
<div class="d-flex justify-content-between">
    <h4 class="rounded" style="color: #004A8E">Penugasan</h4>
    <button class="btn btn-sm btn-primary" id="btn-add-penugasan"><i class="fas fa-plus"></i></button>
</div>
@endsection
@section('content')

<div class="table-responsive">
    <table class="table" id="list-table-tugas">
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>



{{-- <x-modal :id="'modal-add-penugasan'" forms={{$listForms}} btnsv="btn-save-penugasan" title="Tambah Penugasan" size="modal-lg"></x-modal> --}}

<x-base-modal id="modal-add-penugasan" title="Tambah Penugasan" size="modal-lg" position="" >
    <div class="form-group">
        <label for="">Judul</label>
        <input type="text" id="judul" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="">Deskripsi</label>
        <input type="text" class="form-control form-control-sm" id="deskripsi">
    </div>
    <div class="form-group">
        <label for="">File Asal</label>
        <div class="custom-file" id="custom-file-asal">
            <input type="file" class="custom-file-input" id="file_asal" aria-describedby="inputGroupFileAddon01">
            <label class="custom-file-label" for="inputGroupFile01" id="">Choose file</label>
        </div>
        <br>
        <small class="small"></small>
        <div class="btn-group" id="btn-file-asal" hidden>
            <button class="btn btn-sm btn-info" id="btn-detail-file-asal">
                <i class="fas fa-eye" ></i>
            </button>
            <button class="btn btn-sm btn-danger" id="btn-del-file-asal">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <iframe id="iframe_file_asal" src="" frameborder="0" style="display: none"></iframe>
    </div>
    <div class="form-group">
        <label for="">File Hasil</label>
        <div class="custom-file" id="custom-file-hasil">
            <input type="file" class="custom-file-input" id="file_hasil" aria-describedby="inputGroupFileAddon01">
            <label class="custom-file-label" for="inputGroupFile01" id="">Choose file</label>
        </div>
        <br>
        <small class="small"></small>
        <div class="btn-group"  id="btn-file-hasil" hidden>
            <button class="btn btn-sm btn-info" id="btn-detail-file-hasil">
                <i class="fas fa-eye"></i>
            </button>
            <button class="btn btn-sm btn-danger" id="btn-del-file-hasil">
                <i class="fas fa-trash" ></i>
            </button>
        </div>
        <iframe id="iframe_file_hasil" src="" frameborder="0" style="display: none"></iframe>
    </div>
    <div class="d-flex justify-content-end">
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" id="close">Close</button>&nbsp;
        <button class="btn btn-sm btn-primary" id="btn-save-penugasan">Save</button>
    </div>
</x-base-modal>

<x-base-modal id="modal-edit-penugasan" title="Edit Penugasan" size="" position="">
    <input type="text" id="id_penugasan" hidden>
    <div class="form-group">
        <label for="">Judul</label>
        <input type="text" id="judul-edit" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="">Deskripsi</label>
        <input type="text" class="form-control form-control-sm" id="deskripsi-edit">
    </div>
    <div class="form-group">
        <label for="">File Asal</label>
        <div class="custom-file" id="custom-file-asal-edit">
            <input type="file" class="custom-file-input" id="file_asal-edit" aria-describedby="inputGroupFileAddon01">
            <label class="custom-file-label" for="inputGroupFile01" id="">Choose file</label>
        </div>
        <br>
        <small class="small"></small>
        <div class="btn-group" id="btn-file-asal-edit" hidden>
            <button class="btn btn-sm btn-info" id="btn-detail-file-asal-edit">
                <i class="fas fa-eye" ></i>
            </button>
            <button class="btn btn-sm btn-danger" id="btn-del-file-asal-edit">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <iframe id="iframe_file_asal" src="" frameborder="0" style="display: none"></iframe>
    </div>
    <div class="form-group">
        <label for="">File Hasil</label>
        <div class="custom-file" id="custom-file-hasil-edit">
            <input type="file" class="custom-file-input" id="file_hasil-edit" aria-describedby="inputGroupFileAddon01">
            <label class="custom-file-label" for="inputGroupFile01" id="">Choose file</label>
        </div>
        <br>
        <small class="small"></small>
        <div class="btn-group"  id="btn-file-hasil-edit" hidden>
            <button class="btn btn-sm btn-info" id="btn-detail-file-hasil-edit">
                <i class="fas fa-eye"></i>
            </button>
            <button class="btn btn-sm btn-danger" id="btn-del-file-hasi-edit">
                <i class="fas fa-trash" ></i>
            </button>
        </div>
        <iframe id="iframe_file_hasil" src="" frameborder="0" style="display: none"></iframe>
    </div>
    <div class="d-flex justify-content-end">
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" id="close">Close</button>&nbsp;
        <button class="btn btn-sm btn-primary" id="btn-update-penugasan">Save</button>
    </div>
</x-base-modal>

<x-base-modal id="modal-detail-file" title="Detail File" size="" position="">
    <iframe id="iframe_file" src="" frameborder="0" style="width: 100%;height:600px;"></iframe>
</x-base-modal>
@endsection


@section('script')
    <script>


        $('#file_asal').on('change', function () {
            $('#custom-file-asal').attr('hidden', true);
            $('#btn-file-asal').attr('hidden', false);
            var filename = $('#file_asal')[0].files[0].name

            $(this).closest("div").next().closest('.small').empty().append(filename);
        })

        $('#file_hasil').on('change', function () {
            $('#custom-file-hasil').attr('hidden', true);
            $('#btn-file-hasil').attr('hidden', false);
            var filename = $('#file_hasil')[0].files[0].name

            $(this).closest("div").next().closest('.small').empty().append(filename);
        })

        $('#file_asal-edit').on('change', function () {
            $('#custom-file-asal-edit').attr('hidden', true);
            $('#btn-file-asal-edit').attr('hidden', false);
            var filename = $('#file_asal-edit')[0].files[0].name

            $(this).closest("div").next().closest('.small').empty().append(filename);
        })

        $('#file_hasil-edit').on('change', function () {
            $('#custom-file-hasil-edit').attr('hidden', true);
            $('#btn-file-hasil-edit').attr('hidden', false);
            var filename = $('#file_hasil-edit')[0].files[0].name

            $(this).closest("div").next().closest('.small').empty().append(filename);
        })

        $('#btn-del-file-asal').on('click', function () {
            $('#file_asal').val('');
            $('#btn-file-asal').attr('hidden', true);
            $('#custom-file-asal').attr('hidden', false).next().closest('.small').empty();

        })

        $('#btn-del-file-asal-edit').on('click', function () {
            $('#file_asal-edit').val('');
            $('#btn-file-asal-edit').attr('hidden', true);
            $('#custom-file-asal-edit').attr('hidden', false).next().closest('.small').empty();

        })

        $('#btn-del-file-hasil').on('click', function () {
            $('#file_hasil').val('');
            $('#btn-file-hasil').attr('hidden', true);
            $('#custom-file-hasil').attr('hidden', false).next().closest('.small').empty();
        })

        $('#btn-del-file-hasil-edit').on('click', function () {
            $('#file_hasil-edit').val('');
            $('#btn-file-hasil-edit').attr('hidden', true);
            $('#custom-file-hasil-edit').attr('hidden', false).next().closest('.small').empty();
        })

        $('#btn-detail-file-asal').on('click', function () {
            $('#modal-add-penugasan').modal('hide')
            $('#modal-detail-file').modal('show')
                var base64 = $('#file_asal')[0].files[0]
                var filePrev = '';
                $(this).closest("div").prev().closest('iframe').css({'display' :'block'})
                toBase64(base64).then(result => {
                    $('#iframe_file').attr('src', result)
                });
        })

        $('#btn-detail-file-asal-edit').on('click', function () {
            $('#modal-edit-penugasan').modal('hide')
            var url = $(this).data('url')
            console.log(url);
            $('#modal-detail-file').modal('show')
            if (url !=null) {
                $('#iframe_file').attr('src', url)
            }else{
                var base64 = $('#file_asal-edit')[0].files[0]
                var filePrev = '';
                $(this).closest("div").prev().closest('iframe').css({'display' :'block'})
                toBase64(base64).then(result => {
                    $('#iframe_file').attr('src', result)
                });
            }
        })

        $('#btn-detail-file-hasil-edit').on('click', function () {
            $('#modal-edit-penugasan').modal('hide')
            var url = $(this).data('url')
            console.log(url);
            $('#modal-detail-file').modal('show')
            if (url !=null) {
                $('#iframe_file').attr('src', url)
            }else{
                var base64 = $('#file_hasil-edit')[0].files[0]
                var filePrev = '';
                $(this).closest("div").prev().closest('iframe').css({'display' :'block'})
                toBase64(base64).then(result => {
                    $('#iframe_file').attr('src', result)
                });
            }
        })

        $('#modal-detail-file').on('hidden.bs.modal', function () {

            if (localStorage.getItem('mode') == 'add') {
                $('#modal-add-penugasan').modal('show')
            } else if(localStorage.getItem('mode') == 'edit'){
                $('#modal-edit-penugasan').modal('show')
            }
        })

        $('#btn-detail-file-hasil').on('click', function () {
            $('#modal-add-penugasan').modal('hide')
            $('#modal-detail-file').modal('show')
            var filename = $('#file_hasil')[0].files[0].name
                var base64 = $('#file_hasil')[0].files[0]
                var filePrev = '';
                $(this).closest("div").prev().closest('iframe').css({'display' :'block'})
                toBase64(base64).then(result => {
                    $('#iframe_file').attr('src', result)
                });
        })

        $('#list-table-tugas').DataTable({
            serverSide : false,
            processing: true,
            ajax: {
                url : '/api/penugasan',
                type : 'GET'
            },
            columns : [
                {data : 'id', name :"id"},
                {data : 'judul', name :"judul"},
                {data : 'deskripsi', name :"deskripsi"},

                {data : 'id',
                 render : function (data, row, type) {
                    return `
                    <button class="btn btn-sm btn-warning btn-edit-penugasan" data-id="${data}">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    <a class="btn btn-sm btn-info btn-detail-penugasan" href="penugasan/${data}">
                        <i class="fas fa-eye"></i>
                    </a>
                    <button class="btn btn-sm btn-danger btn-delete-penugasan" data-id="${data}">
                        <i class="fas fa-trash"></i>
                    </button>`
                 }
                },

            ]
        })

        $('#btn-add-penugasan').on("click", function () {
            localStorage.setItem('mode', 'add');
            $('#modal-add-penugasan').modal('show');
        })

        $('body').on('click', '.btn-edit-penugasan', function () {
            localStorage.setItem('mode', 'edit');
            $('#modal-edit-penugasan').modal('show');
            var id = $(this).data('id');
            getDetail('/api/penugasan/detail/' +id)
            setTimeout(() => {
                var detail = dataDetail;
                // console.log(detail);
                $('#judul-edit').val(detail.judul);
                $('#deskripsi-edit').val(detail.deskripsi);
                $('#id_penugasan').val(detail.id);
                $('#btn-detail-file-asal-edit').data('url', `{{asset('storage/asal/${detail.file_asal}')}}`);
                $('#btn-detail-file-hasil-edit').data('url', `{{asset('storage/hasil/${detail.file_hasil}')}}`);
                $('#custom-file-asal-edit').attr('hidden', true);
                $('#btn-file-asal-edit').attr('hidden', false);
                $('#custom-file-hasil-edit').attr('hidden', true);
                $('#btn-file-hasil-edit').attr('hidden', false);

            }, 1000);
        })

        $('body').on('click', '.btn-delete-penugasan', function () {
            var id = $(this).data('id')
            Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Mahasiswa ini akan terhapus beserta data yang berhubungan dengannya!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!'
          }).then((result) => {
                if (result.isConfirmed) {
                    console.log(id);
                    $.ajax({
                        url : '/api/penugasan/' + id,
                        type : "DELETE",
                        headers : {
                            'Authorization' : "Bearer "+ curCookie
                        },
                        success :function (data) {
                            alertSuccess("berhasil dihapus")
                            $('#list-table-tugas').DataTable().ajax.reload()
                        },
                        error : function (data) {
                            alertError(data.responseJSON.message)
                        }
                    })
                }
            })
        });

        $('#btn-save-penugasan').on('click', function () {
            $('#screen-loader').attr('hidden', false)
            var fd = new FormData();
            fd.append('file_asal',$('#file_asal')[0].files[0]);
            fd.append('file_hasil', $('#file_hasil')[0].files[0]);
            fd.append('judul', $('#judul').val());
            fd.append('deskripsi', $('#deskripsi').val());
            $.ajax({
                url : "/api/penugasan",
                type : "POST",
                processData: false,
                contentType: false,
                data :fd,
                success : function (data) {
                    $('#screen-loader').attr('hidden', true)
                    alertSuccess("Data Berhasil Disimpan");
                    $('#modal-add-penugasan').modal('hide');
                    $('#list-table-tugas').DataTable().ajax.reload()
                    $('#file_asal').empty()
                    $('#file_hasil').empty()
                    $('#judul').empty()
                    $('#deskripsi').empty()
                },
                error : function (data) {
                    $('#screen-loader').attr('hidden', true)
                    alertError("Data Gagal Disimpan");
                }
            })
        })

        $('#btn-update-penugasan').on('click', function () {
            $('#screen-loader').attr('hidden', false)
            var id = $('#id_penugasan').val();
            var fd = new FormData();
            if ($('#file_asal-edit')[0].files[0] == undefined) {
                fd.append('file_asal', null);
            } else {
                fd.append('file_asal',$('#file_asal-edit')[0].files[0]);
            }

            if ($('#file_hasil-edit')[0].files[0] == undefined) {
                fd.append('file_hasil', null);
            }else{
                fd.append('file_hasil', $('#file_hasil-edit')[0].files[0]);
            }

            fd.append('judul', $('#judul-edit').val());
            fd.append('deskripsi', $('#deskripsi-edit').val());
            $.ajax({
                url : "/api/penugasan/"+id,
                type : "POST",
                processData: false,
                contentType: false,
                data :fd,
                success : function (data) {
                    $('#screen-loader').attr('hidden', true)
                    console.log(data);
                    alertSuccess("Data Berhasil Diubah");
                    $('#modal-edit-penugasan').modal('hide');
                    $('#list-table-tugas').DataTable().ajax.reload()
                    $('#file_asal-edit').empty()
                    $('#file_hasil-edit').empty()
                    $('#judul-edit').empty()
                    $('#deskripsi-edit').empty()
                },
                error : function (data) {
                    $('#screen-loader').attr('hidden', true)
                    alertError("Data Gagal Diubah");
                }
            })
        })
    </script>
@endsection
