@extends('layouts.app')

@section('title')
<div class="row d-flex justify-content-between">
    <div class="col">
        <h4 class="rounded" style="color: #004A8E">Dosen</h4>
    </div>
    <div class="col text-right">
        <button class="btn btn-sm btn-primary" id="btn-add-dosen"><i class="fas fa-plus"></i></button>
    </div>

</div>

@endsection

@section('content')

<div class="table-responsive">
    <table class="table" id="list-table-dosen">
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>

                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<x-base-modal id="modal-detail-dosen" title="Desain Dosen" size="" position="">
    <div class="form-group">
        <label for="name">Nama</label>
        <input type="text" name="name-detail" id="name-dosen-detail" class="form-control">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" name="email-dosen-detail" id="email-dosen-detail" class="form-control">
    </div>
    <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea name="alamat-dosen-detail" id="alamat-dosen-detail" cols="30" rows="5" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label for="alamat">NIDN</label>
        <input type="text" id="nidn-dosen-detail" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="no_hp">No Hp</label>
        <input type="text" name="no_hp-dosen-detail" id="no_telp-dosen" class="form-control">
    </div>
    <div class="form-group">
        <label for="password">Kelas</label>
        <br>
        <span id="kelas-detail"></span>
        {{-- <select name="" multiple class="select-kelas form-control " id="kelas-dosen"></select> --}}
    </div>

    <div class="d-flex justify-content-end">
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" id="close">Close</button>&nbsp;
        <button class="btn btn-sm btn-primary" id="btn-save-dosen">Save</button>
    </div>
</x-base-modal>

<x-base-modal id="modal-add-dosen" title="Tambah Dosen" size="" position="">
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name-dosen" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email-dosen" id="email-dosen" class="form-control">
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat-dosen" id="alamat-dosen" cols="30" rows="5" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="alamat">NIDN</label>
            <input type="text" id="nidn-dosen" class="form-control form-control-sm">
        </div>
        <div class="form-group">
            <label for="no_hp">No Hp</label>
            <input type="text" name="no_hp-dosen" id="no_telp-dosen" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Kelas</label>
            <br>
            <select name="" multiple class="select-kelas form-control " id="kelas-dosen"></select>
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-sm btn-secondary" data-dismiss="modal" id="close">Close</button>&nbsp;
            <button class="btn btn-sm btn-primary" id="btn-save-dosen">Save</button>
        </div>
</x-base-modal>
@endsection


@section('script')
    <script>


 $('#list-table-dosen').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                'url' : '/api/dosen',
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'user.name', name: 'name'},
                {data: 'user.email', name: 'email'},

                {data: 'id', name: 'action', orderable: false, searchable: false,
                    render : function(data, type, row){
                        return `
                                <button data-id=${data}   class="btn btn-sm btn-info btn-detail-dosen"><i class="fas fa-eye"></i></button>
                                <button data-id=${data}   class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>`
                    }
                },
            ]
        })

        $('body').on('click', '.btn-detail-dosen', function () {
            $('#modal-detail-dosen').modal('show')
            var data ;
            var id = $(this).data('id')
             getDetail('/api/dosen/'+id);
             setTimeout(() => {
                 data= dataDetail;
                 console.log(data);
                 $('#name-dosen-detail').val(data.user.name)
                    $('#email-dosen-detail').val(data.user.email)
                    $('#alamat-dosen-detail').val(data.user.alamat)
                    $('#nidn-dosen-detail').val(data.nidn)
                    $('#no_telp-dosen-detail').val(data.user.no_telp)
                    // var kelas = JSON.parse(data.kelas);
                    $('#kelas-detail').html(data.kelas.map(function(item){
                        return `<span class="badge badge-info">${item}</span>&nbsp;`
                    }))
             }, 1000);
        })

        function selectClass() {
            $('.select-kelas').select2({
            width:'100%',
            ajax : {
                url : '/api/kelas',

                processResults : function(data){
                    var res = data.data.map(function(item){
                        return {
                            id : item.id,
                            text : item.name
                        }
                    })
                    console.log(res);
                    return {
                        results :res
                    }
                }
            }
        })

        }

        $('#btn-add-dosen').on('click', function(){
            $('#modal-add-dosen').modal('show')
            selectClass();
            // $.ajax({
            //     url : '/api/kelas',
            //     type : 'GET',
            //     success : function(res){
            //         // let html = ''
            //         // res.data.forEach(element => {
            //         //     html += `<option value="${element.id}">${element.name}</option>`
            //         // });
            //         // $('#kelas-dosen').html(html)
            //         selectClass()
            //     }
            // })
        })

        $('#btn-save-dosen').on('click', function () {
            $.ajax({
                url : '/api/dosen',
                type : 'POST',
                data : {
                    name : $('#name-dosen').val(),
                    email : $('#email-dosen').val(),
                    alamat : $('#alamat-dosen').val(),
                    no_hp : $('#no_telp-dosen').val(),
                    nidn : $('#nidn-dosen').val(),
                    kelas : $('#kelas-dosen').val(),
                },
                success : function(res){
                    $('#modal-add-dosen').modal('hide')
                    $('#list-table-dosen').DataTable().ajax.reload()
                },
                error : function(err){
                    alertError(err.responseJSON.message)
                }
            })
        });
    </script>
@endsection
