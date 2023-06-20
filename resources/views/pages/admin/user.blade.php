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

<x-modals id="modal-detail-user" size="" custombtn="" title="Detail User" btnsv="" position="modal-dialog-centered" attr="hidden">
    <table>
        <tr>
            <td style="width: 100px">Name</td>
            <td>Auful</td>
        </tr>
        <tr>
            <td style="width:100px">Email</td>
            <td>auful@gmail.com</td>
        </tr>
        <tr>
            <td style="width: 100px">Status</td>
            <td><span class="badge badge-pills badge-success">Aktif</span></td>
        </tr>
    </table>
</x-modals>



<x-modals id="modal-edit-user" size=""  title="Detail User" btnsv="" position="modal-dialog-centered" attr="hidden" custombtn="">
    <table>
        <tr>
            <td style="width: 100px">Name</td>
            <td>Auful</td>
        </tr>
        <tr>
            <td style="width:100px">Email</td>
            <td>auful@gmail.com</td>
        </tr>
        <tr>
            <td style="width: 100px">Status</td>
            <td><span class="badge badge-pills badge-success">Aktif</span></td>
        </tr>
    </table>
</x-modals>
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
                        return `<button data-id=${data}  class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i></button>
                                <button data-id=${data}   class="btn btn-sm btn-info btn-detail-user"><i class="fas fa-eye"></i></button>
                                <button data-id=${data}   class="btn btn-sm btn-danger" btn-del-user><i class="fas fa-trash"></i></button>`
                    }
                },
            ]
        })


        $('body').on('click', '.btn-detail-user', function () {
            $('#modal-detail-user').modal('show');
        })

    </script>
@endsection
