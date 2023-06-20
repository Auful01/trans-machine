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
            'label' => 'nama',
            'type'  => 'text',
          ],
         [
            'label' => 'nim',
            'type'  => 'number'
          ]
        ];

        $import = [
            [
                'label' => 'notes',
                'type' => 'notes_warning',
                'description' => 'Please file import type is .xlsx, and Format of column is blbalbalab'
            ],
            [
                'label' => 'file_import',
                'type' => 'file',
                'accept' => 'excel'
            ]
        ];
    $listForms = json_encode($listForms);
    $import = json_encode($import);

@endphp

<x-modal :id="'modal-add-mhs'" forms={{$listForms}} btnsv="btn-save-mhs" title="Tambah Mahasiswa" size="" />

<x-modal :id="'modal-import-mhs'" forms={{$import}} btnsv="btn-save-import" title="Import Mahasiswa" size=""/>

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
