@extends('layouts.app')

@section('title')
<div class="d-flex justify-content-between">
    <h4 class="rounded" style="color: #004A8E">Mahasiswa</h4>
    @if (auth()->user()->role_id == 1)

    <div>
        <a href="{{url('admin/mahasiswa/export')}}" class="btn btn-danger btn-sm" id="btn-export-mhs">
            @csrf
            <i class="fas fa-file-download"></i>
        </a>
        <button class="btn btn-success btn-sm" id="btn-import-mhs">
            <i class="fas fa-file-excel"></i>
        </button>
        <button class="btn btn-sm btn-primary" id="btn-add-mhs">
            <i class="fas fa-plus"></i>
        </button>
    </div>
    @endif
</div>
@endsection


@section('content')

<div class="table-responsive">
    <table class="table" id="list-table-mhs">
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>NIM</th>
                <th>Status</th>
                {{-- @if (auth()->user()->role_id == 1) --}}
                <th>Aksi</th>
                {{-- @endif --}}
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

@php
     $listForms = [
          [
            "label" => "nama",
            "type"  => "text",
          ],
         [
            "label" => "nim",
            "type"  => "number"
          ]
        ];

        $import = [
            [
                "label" => "notes",
                "type" => "notes_warning",
                "description" => "Please file import type is .xlsx, and Format of column is blbalbalab"
            ],
            [
                "label" => "file_import",
                "type" => "file",
                "accept" => "excel"
            ]
        ];
    $listForms = json_encode($listForms, true);
    $import = json_encode($import, true);

@endphp


<x-base-modal id="modal-add-mhs" title="Tambah Mahasiswa" size="" position="">
    <div class="form-group">
        <label for="">Nama</label>
        <input type="text" class="form-control form-control-sm" id="nama">
    </div>
    <div class="form-group">
        <label for="">NIM</label>
        <input type="text" name="" id="nim" class="form-control form-control-sm">
    </div>
    <div class="text-right">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button class="btn btn-sm btn-primary" id="btn-save-mhs">Simpan</button>
    </div>
</x-base-modal>

<x-base-modal id="modal-import-mhs" size="" title="Import Mahasiswa" position="">
    <div style="border: 2px dashed rgb(222, 180, 43);background: rgba(224, 191, 28, 0.35);border-radius: 8px;padding:10px;">
        <h5 class="text-uppercase">Notes</h5>
        <p style="font-size: 10pt;font-style: italic">
            Please file import type is .xlsx, and Format of column is blbalbalab
        </p>
    </div>
    {{-- <iframe src="" id="iframe_{{$item->label}}" frameborder="0" style="width: 100%;height:600px;display:none"></iframe> --}}
    <div class="custom-file my-3">
        <input type="file" class="custom-file-input" id="file_import" accept="{{App\Helpers\CheckType::accFiles('excel')}}" aria-describedby="inputGroupFileAddon01">
        <label class="custom-file-label" for="inputGroupFile01" id="label-file_import">Choose file</label>
    </div>
    <div class="text-right">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button class="btn btn-sm btn-primary" id="btn-save-import">Simpan</button>
    </div>
</x-base-modal>
@endsection


@section('script')
    <script>
        var curCookie  =  Cookies.get('admin_cookie') != null ? Cookies.get('admin_cookie') :  Cookies.get('dosen_cookie');
        var queryId =  new URLSearchParams(window.location.search);

 $('#list-table-mhs').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                'url' : '/api/mahasiswa/kelas/' + queryId.get('kelas_id'),
                'headers' : {
                    'Authorization' : 'Bearer ' + curCookie
                }
            },
            columns: [
                {data: 'id', name: 'id',
                render : function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: 'user.name', name: 'name'},
                {data: 'user.email', name: 'email'},
                {
                    data:'nim'
                },
                {data: 'user.status', render : function(data, type, row){
                    if(data == 'aktif'){
                        return `<span class="badge badge-pills badge-success">Aktif</span>`
                    }else{
                        return `<span class="badge badge-pills badge-danger">Tidak Aktif</span>`
                    }
                }},

                {data: 'id', name: 'action', orderable: false, searchable: false,
                    render : function(data, type, row){
                            // return
                            return `<button data-id=${data}  class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i></button>
                                    <button data-id=${data}   class="btn btn-sm btn-info btn-detail-user"><i class="fas fa-eye"></i></button>
                                    <button data-id=${data}   class="btn btn-sm btn-danger btn-hapus-mhs"><i class="fas fa-trash"></i></button>`

                    }
                },
            ]
        })

        $('#btn-add-mhs').on('click',function () {
            $('#modal-add-mhs').modal('show')
        })
        $('#btn-import-mhs').on('click',function () {
            $('#modal-import-mhs').modal('show')
        })

        $('#btn-save-mhs').on('click', function () {

            $.ajax({
                url : "/api/mahasiswa",
                type : 'POST',

                headers : {
                    'Authorization' : 'Bearer ' + curCookie
                },
                data : {
                    'name' : $('#nama').val(),
                    'kelas_id' :  queryId.get('kelas_id'),
                    'nim' : $('#nim').val()
                },
                success : function (data) {
                    alertSuccess('Data Mahasiswa Berhasil Ditambahkan')
                    $('#list-table-mhs').DataTable().ajax.reload()
                },
                error : function (data) {
                    alertError(data.message);
                }
            })
        })

        $('body').on('click', '.btn-hapus-mhs', function () {
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

                $.ajax({
                    url : '/api/mahasiswa/' + id,
                    type: 'DELETE',
                    headers : {
                        'Authorization':  'Bearer ' + curCookie,
                    },
                    success : function (data) {
                        console.log(data);
                        alertSuccess("Berhasil mengirimkan jawaban");
                        $('#list-table-mhs').DataTable().ajax.reload()
                        // window.location.href = '../'
                    },
                    error : function (err) {
                        alertError(err.responseJSON.message);

                    }
                })
            }
          })
        })


        $('#file_import').on('change', function () {
            var filename = $('#file_import')[0].files[0].name
            $(this).closest("div").next().closest('.small').empty().append(filename);
        })

        $('#btn-save-import').on('click', function () {
            var fd = new FormData();
            fd.append("file_mhs", $('#file_import')[0].files[0]);
            $.ajax({
                url : '/api/mahasiswa/import',
                type : 'POST',
                headers : {
                    'Authorization' : 'Bearer ' + curCookie
                },
                processData: false,
                contentType: false,
                header : {

                },
                data: fd,
                success : function (data) {
                    alertSuccess("Data Mahasiswa Berhasil Di Import")
                    $('#modal-import-mhs').modal('hide')
                    $('#list-table-mhs').DataTable().ajax.reload()
                }
            })
        })



    </script>
@endsection
