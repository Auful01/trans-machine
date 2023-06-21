@extends('layouts.app')

@section('title')
<div class="d-flex justify-content-between">
    <h4 class="rounded" style="color: #004A8E">User</h4>
</div>
@endsection

@section('content')

<div class="table-responsive">
    <table class="table" id="list-table-user">
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@props(['forms'])

@php
     $listForms = [
          [
            'label' => 'nama',
            'type'  => 'text',
          ],
          [
            'label' => 'kelas',
            'type' => 'dropdown',
            'items' => App\Models\Kelas::all()
          ],[
            'label' => 'nim',
            'type'  => 'number'
          ]
        ];


    $listForms = json_encode($listForms);
@endphp

{{-- <x-modal :id="'modal-detail-user'" forms={{$listForms}} btnsv="" title="Detail User" size=""/> --}}

<x-base-modal id="modal-detail-user" size="" custombtn="" title="Detail User" btnsv="" position="modal-dialog-centered" attr="hidden">
    <table>
        <tr>
            <td style="width: 100px">Name</td>
            <td id="nama">Auful</td>
        </tr>
        <tr>
            <td style="width:100px">Email</td>
            <td id="email">auful@gmail.com</td>
        </tr>
        <tr>
            <td style="width: 100px">Status</td>
            <td id="status"></td>
        </tr>
    </table>
</x-base-modal>



<x-base-modal id="modal-edit-user" size=""  title="Detail User" btnsv="" position="modal-dialog-centered" attr="hidden" custombtn="">
    <div class="form-group">
        <label for="">Name</label>
        <input type="text" class="form-control form-control-sm" id="nama_edit" disabled>
    </div>
    <div class="form-group">
        <label for="">Email</label>
        <input type="text" class="form-control form-control-sm" id="email_edit" disabled>
    </div>
    <div class="form-group">
        <label for="">New Password</label>
        <div class="input-group">
            <input type="password" class="form-control form-control-sm" id="password_edit">
            <div class="input-group-append">
                <button class="btn btn-sm btn-outline-secondary" type="button" id="btn-eye-slash">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="text-right">
        <button class="btn btn-sm btn-secondary" type="button" id="btn-cancel-edit-user">Cancel</button>
        <button class="btn btn-sm btn-primary" type="button" id="btn-update-user">Simpan</button>
    </div>
</x-base-modal>
@endsection


@section('script')
    <script>
        $('#list-table-user').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                'url' : '/api/user',
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'status', render : function(data, type, row){
                    if(data == 'aktif'){
                        return `<span class="badge badge-pills badge-success">Aktif</span>`
                    }else{
                        return `<span class="badge badge-pills badge-danger">Tidak Aktif</span>`
                    }
                }},
                {data: 'id', name: 'action', orderable: false, searchable: false,
                    render : function(data, type, row){
                        return `<button data-id=${data}  class="btn btn-sm btn-warning btn-edit-user"><i class="fas fa-pencil-alt"></i></button>
                                <button data-id=${data}   class="btn btn-sm btn-info btn-detail-user"><i class="fas fa-eye"></i></button>
                                <button data-id=${data}   class="btn btn-sm btn-danger btn-del-user"><i class="fas fa-trash"></i></button>`
                    }
                },
            ]
        })

        $('#btn-eye-slash').on('click', function () {
            console.log($(this).find('i').hasClass('fa-eye'));
            if($(this).find('i').hasClass('fa-eye')){
                $(this).find('i').removeClass('fa-eye')
                $(this).find('i').addClass('fa-eye-slash')
                $('#password_edit').attr('type', 'text')
            }else{
                $(this).find('i').removeClass('fa-eye-slash')
                $(this).find('i').addClass('fa-eye')
                $('#password_edit').attr('type', 'password')
            }
        })

        $('body').on('click', '.btn-edit-user', function () {
            $('#modal-edit-user').modal('show');
            var id = $(this).data('id');
            $.ajax({
                url: '/api/user/'+ id,
                type: 'GET',
                success: function (data) {
                    console.log(data.data.email);
                    $('#btn-update-user').data('id',id);
                    console.log(id);
                    $("#nama_edit").val(data.data.name).attr("disabled", true)
                    $("#email_edit").val(data.data.email).attr("disabled", true)
                    // $("#status").html(data.data.status == 'aktif' ? `<span class="badge badge-pills badge-success">Aktif</span>` : `<span class="badge badge-pills badge-danger">Tidak Aktif</span>`)
                }
            })
        })
        $('body').on('click', '.btn-detail-user', function () {
            $('#modal-detail-user').modal('show');
            $.ajax({
                url: '/api/user/'+$(this).data('id'),
                type: 'GET',
                success: function (data) {
                    $('#btn-update-user').data('id', $(this).data('id'))
                    console.log( $(this).data("id"));
                    console.log(data.data.email);
                    $("#nama").html(data.data.name)
                    $("#email").html(data.data.email)
                    $("#status").html(data.data.status == 'aktif' ? `<span class="badge badge-pills badge-success">Aktif</span>` : `<span class="badge badge-pills badge-danger">Tidak Aktif</span>`)
                }
            })
        })

        $('#btn-update-user').on('click', function () {
            console.log(

                $('#btn-update-user').data('id')
            )
            $.ajax({
                url: '/api/update/' + $(this).data('id'),
                type: 'PUT',
                data: {
                    name: $('#nama_edit').val(),
                    email: $('#email_edit').val(),
                    password: $('#password_edit').val(),
                },
                success: function (data) {
                    console.log(data);
                    alertSuccess("Data Berhasil Diupdate")
                    $('#modal-edit-user').modal('hide').find('input').val('');
                    $('#list-table-user').DataTable().ajax.reload();
                },
                error: function (data) {
                    console.log(data);
                    alertError("Data Gagal Diupdate")
                }
            })

        })
    </script>
@endsection
