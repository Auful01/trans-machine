@extends('layouts.app')

@section('title')
    <div class="d-flex justify-content-between">
        <h4 class="rounded m-0 " style="color: #004A8E">Detail Penugasan Kelas</h4>
        <a href="" class="btn btn-sm btn-primary" id="btn-back-penugasan">
            {{-- <i class="fas fa-chevron-left mr-2 " style="font-size: 15pt;color:#004A8E"></i> --}}
            <i class="fas fa-chevron-left mr-2 " ></i> Kembali
        </a>
    </div>
@endsection

@section('content')
<div>
    <div class="table-responsive">
        <table class="table" id="table-detail-tugas-kelas">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Status</th>
                    <th>Status Review</th>
                    <th>Nilai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

@php
    $listForm = [
        [
            'label' => 'list_kelas',
            'type'  => 'dropdown',
            'items' => App\Models\Kelas::all()
        ],[
            'label' => 'tanggal_mulai',
            'type'  => 'date'
        ],[
            'label' => 'tanggal_selesai',
            'type'  => 'date'
        ]
    ];

    $listForm = json_encode($listForm);
@endphp

<x-modal :id="'modal-assign-task'" forms={{$listForm}} btnsv="btn-save-assign" title="Assign Task" size=""></x-modal>
@endsection

@section('script')

    <script>
        $(document).ready(function () {
            var lastUrl = window.location.pathname.split("/")
            // var lts = lastUrl[lastUrl.length - 1]
            localStorage.setItem("lts",lastUrl[lastUrl.length - 1] )
            // console.log();/
            $.ajax({
                url : '/api/penugasan/kelas/' + getSegment(),
                header : {

                },
                type : 'GET',
                success: function (data) {
                    console.log(data);
                }
            })

           $('#btn-back-penugasan').attr('href', '/admin/penugasan/' + getSegment())
        })

        $('#table-detail-tugas-kelas').DataTable({
            serverSide : false,
            processing : true,
            ajax : {
                url : '/api/penugasan/kelas/' + getSegment(),
                header : {

                },
                type : 'GET'
            },
            columns : [
            {
                data : 'mahasiswa_id',
                function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
            },
            {
                data  : 'name'
            },
            {
                data  : 'nim'
            },
            {
                data : 'status',
                render : function (data, row, type,meta) {
                    if (data == null || data == 'unsubmitted') {
                        return 'unsubmitted'
                    }
                    return data
                }
            },
            {
                data : 'is_review',
                render : function (data, row, type,meta) {
                    if (data == null || data == 0) {
                        return 'Not Review'
                    }else{
                        return 'Reviewed'
                    }
                }
            },
            {
                data : 'nilai',

            },
            {
                data : 'penugasan_kelas_id',
                render : function (data,  type, row,meta) {
                    console.log(type);
                    return `
                                <a href="/admin/penugasan/mahasiswa/${data}?mhs_id=${row.mahasiswa_id}"   class="btn btn-sm btn-info btn-detail-penugasan-kelas"><i class="fas fa-eye"></i></a>
                                `
                }
            }
            ]
        })

        $('#btn-assign-task').on('click', function () {
            $('#modal-assign-task').modal('show');
        })

        // $('body').on('click', '.btn-detail-penugasan-kelas', function () {

        // })

        $('#btn-save-assign').on('click', function () {
            $('#screen-loader').attr('hidden', 'false')
            $.ajax({
                url : '/api/penugasan/kelas',
                type : 'POST',
                data : {
                    'penugasan_id' : {{request()->segment(count(request()->segments()))}},
                    'kelas_id' : $('#list_kelas').val(),
                    'tanggal_mulai' : $('#tanggal_mulai').val(),
                    'tanggal_selesai' : $('#tanggal_selesai').val(),
                },
                success : function (data) {
                    alertSuccess('Data berhasil Disimpan');
                    // console.log(data);
                    $('#screen-loader').attr('hidden', 'true')
                    $('#modal-assign-task').modal('hide');
                },
                error : function (data) {
                    alertError("data.responseJSON.message");
                }
            })
        })
    </script>
@endsection
