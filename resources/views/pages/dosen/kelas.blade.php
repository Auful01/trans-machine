@extends('layouts.app')

@section('title')
<div class="d-flex justify-content-between">
    <h4 class="rounded" style="color: #004A8E">Kelas</h4>

</div>
@endsection

@section('content')

<div class="table-responsive">
    <table class="table" id="list-table-kelas">
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Aksi</th>
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
            'type'  => 'text'
        ],[
            'label' => 'dosen',
            'type'  => 'dropdown',
            'items' => App\Models\User::where('role_id', 2)->get()
        ]
    ];


    $listForms = json_encode($listForms);
@endphp

<x-modal :id="'modal-detail-kelas'" forms={{$listForms}} btnsv="btn-save-kelas" title="Tambah Kelas" size=""/>

@endsection


@section('script')
    <script>
        $(document).ready(function () {
           $.ajax({
                url : '/api/kelas/my',
                type :'GET',
                headers: {
                    'Authorization' : `Bearer ${curCookie}`
                },
                success : function (data) {
                    console.log(data.data.list_kelas);
                }
           })
        })

        $('#list-table-kelas').DataTable({
            processing : true,
            serverSide : false,
            ajax : {
                url : '/api/kelas/my',
                type :'GET',
                headers: {
                    'Authorization' : `Bearer ${curCookie}`
                },
                dataSrc : 'data.list_kelas'
            },
            columns : [
                {
                    data : 'id',
                    name : 'id'
                },
                {
                    data : 'name',
                    name : 'name'
                },{
                    data : "id",
                    render : function (data, type, row) {
                        return `
                        <a class="btn btn-sm btn-info btn-detail-kelas" href="${window.location.origin + '/dosen/mahasiswa?kelas_id=' + data}" data-id="${data}"><i class="fas fa-eye"></i></a>
            `
                    }
                }
            ]
        })


        $('#btn-add-kelas').on('click', function () {
            $('#modal-detail-kelas').modal('show')
        })

        $('#btn-save-kelas').on('click', function () {
            $.ajax({
                url: '/api/kelas',
                type: 'POST',
                data : {
                    name : $('#nama').val(),
                    dosen_id : $('#dosen').val()
                },
                success : function (data) {
                    alertSuccess("Data Berhasil Disimpan")
                    $('#modal-detail-kelas').modal('hide')
                    $('#list-table-kelas').DataTable().ajax.reload()

                }
            })
        })
    </script>
@endsection
