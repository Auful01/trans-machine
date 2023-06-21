@extends('layouts.app')

@section('title')
<div class="d-flex justify-content-between">
    <h4 class="rounded" style="color: #004A8E">Kelas</h4>
    <div>
        <button class="btn btn-sm btn-primary " id="btn-add-kelas">
            <i class="fas fa-plus"></i>
        </button>
    </div>
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
{{--
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

<x-modal :id="'modal-detail-kelas'" forms={{$listForms}} btnsv="btn-save-kelas" title="Tambah Kelas" size=""/> --}}

<x-base-modal id="modal-add-kelas" title="Tambah kelas" size="" position="">
    <div class="form-group">
        <label for="">Nama</label>
        <input type="text" class="form-control form-control-sm" id="nama">
    </div>
    <div class="text-right">
        <button class="btn btn-sm btn-primary" id="btn-save-kelas">Simpan</button>
    </div>
</x-base-modal>

<x-base-modal id="modal-detail-kelas" title="Tambah kelas" size="" position="">
    <div class="form-group">
        <label for="">Nama</label>
        <input type="text" class="form-control form-control-sm" id="nama_edit">
    </div>
    <div class="text-right">
        <button class="btn btn-sm btn-primary" id="btn-update-kelas">Simpan</button>
    </div>
</x-base-modal>

@endsection


@section('script')
    <script>
        $('#list-table-kelas').DataTable({
            processing : true,
            serverSide : false,
            ajax : {
                url : '/api/kelas',
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
                        return `   <button class="btn btn-sm btn-warning btn-edit-kelas" data-id="${data}"><i class="fas fa-pencil-alt"></i></button>
                        <a class="btn btn-sm btn-info btn-detail-kelas" href="${window.location.origin + '/admin/mahasiswa?kelas_id=' + data}" data-id="${data}"><i class="fas fa-eye"></i></a>
            <button class="btn btn-sm btn-danger btn-delete-kelas" data-id="${data}"> <i class="fas fa-trash"></i> </button>`
                    }
                }
            ]
        })


        $('#btn-add-kelas').on('click', function () {
            $('#modal-add-kelas').modal('show')
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

        $('#btn-update-kelas').on('click', function () {
            $.ajax({
                url: '/api/kelas/' + $('.btn-edit-kelas').data('id'),
                type: 'POST',
                data : {
                    name : $('#nama_edit').val(),
                },
                success : function (data) {
                    alertSuccess("Data Berhasil Disimpan")
                    $('#modal-detail-kelas').modal('hide')
                    $('#list-table-kelas').DataTable().ajax.reload()

                }
            })
        })

        $('body').on('click', '.btn-edit-kelas', function () {
            $.ajax({
                url: '/api/kelas/' + $(this).data('id'),
                type: 'GET',
                success : function (data) {
                    $('#nama_edit').val(data.data.name)
                    $('#modal-detail-kelas').modal('show')
                }
            })
        })

        $('body').on('click', '.btn-delete-kelas', function () {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#004A8E',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // deleteKelas($(this).data('id'))
                    $.ajax({
                        url: '/api/kelas/' + $(this).data('id'),
                        type: 'DELETE',
                        success : function (data) {
                            alertSuccess("Data Berhasil Dihapus")
                            $('#list-table-kelas').DataTable().ajax.reload()
                        },
                        error : function (data) {
                            alertError(data.responseJSON.message);
                        }
                    })
                }
            })
        })
    </script>
@endsection
