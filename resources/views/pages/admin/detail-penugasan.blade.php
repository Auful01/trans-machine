@extends('layouts.app')

@section('title')
    <div class="d-flex justify-content-between">

        <h4 class="rounded m-0 " style="color: #004A8E">Detail Penugasan</h4>
        <a href="/admin/penugasan" class="btn btn-sm btn-primary  my-auto ">
            <i class="fas fa-chevron-left mr-2 " ></i> Kembali
        </a>
    </div>
@endsection

@section('content')
<div>
    <input type="text" value="{{$tugas->id}}" id="tugas_id" hidden >
    <h1 id="title-tugas">{{$tugas->judul}}</h1>
    <p id="deskripsi">
        {{$tugas->deskripsi}}
    </p>

    <button class="btn btn-sm btn-primary mb-3" id="btn-assign-task">
        <i class="fas fa-paper-plane"></i>&nbsp; Assign task
    </button>

    <div class="table-responsive">
        <table class="table" id="table-detail-tugas">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Presentase Pengumpulan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<x-base-modal id="modal-assign-task" title="Assign Task" size="" position>

        <div class="form-group">
            <label for="password">Kelas</label>
            <br>
            <select name="" multiple class="select-mykelas form-control " id="list_kelas"></select>
        </div>

    <div class="form-group">
        <label for="">Tanggal Mulai</label>
        <input type="date" class="form-control" id="tanggal_mulai">
    </div>
    <div class="form-group">
        <label for="">Tanggal Selesai</label>
        <input type="date" class="form-control" id="tanggal_selesai">
    </div>

    <div class="d-flex justify-content-end">
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" id="close">Close</button>&nbsp;
        <button class="btn btn-sm btn-primary" id="btn-save-assign">Save</button>
    </div>
</x-base-modal>
@endsection

@section('script')
    <script>
         function selectMyClass() {
            $('.select-mykelas').select2({
            width:'100%',
            ajax : {
                url : '/api/kelas/my',
                headers : {
                    'Authorization' : `Bearer ${curCookie}`
                },
                processResults : function(data){
                    var res = data.data.list_kelas.map(function(item){
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

        $(document).ready(function () {
            $.ajax({
                url : '/api/penugasan/kelas?id=' + $('#tugas_id').val(),
                type : 'GET',
                success : function (data) {
                    console.log(data)
                }
            })
        })

        $('#table-detail-tugas').DataTable({
            serverSide : false,
            processing : true,
            ajax : {
                url : '/api/penugasan/kelas?id=' + $('#tugas_id').val(),
                header : {
                    'Authorization' : `Bearer ${curCookie}`
                }
            },
            columns : [
            {
                data : 'id',
            },
            {
                data  : 'name'
            },
            {
                data : 'id',
                render : function (data, row, type) {
                    var percentage = (type['submitted'] / (type['unsubmitted'] + type['submitted'])) * 100;
                    return `${!isNaN(percentage) ? percentage.toFixed(2) : '0'} %`;
                }
            },
            {
                data : 'id',
                render : function (data, row, type) {
                    return `
                                <a  href="/admin/penugasan/kelas/${data}""   class="btn btn-sm btn-info btn-detail-user"><i class="fas fa-eye"></i></a>
                                `
                }
            }
            ]
        })

        $('#btn-assign-task').on('click', function () {
            $('#modal-assign-task').modal('show');
            selectMyClass();
        })

        $('#btn-save-assign').on('click', function () {
            $('#screen-loader').attr('hidden', 'false')
            localStorage.setItem("curSegment", {{request()->segment(count(request()->segments()))}});
            console.log(curCookie)
            $.ajax({
                url : '/api/penugasan/kelas',
                type : 'POST',
                headers: {
                    'Authorization' : `Bearer ${curCookie}`
                },
                data : {
                    'penugasan_id' : {{request()->segment(count(request()->segments()))}},
                    'kelas_id' : $('#list_kelas').val(),
                    'tanggal_mulai' : $('#tanggal_mulai').val(),
                    'tanggal_selesai' : $('#tanggal_selesai').val(),
                },
                success : function (data) {
                    alertSuccess('Data berhasil Disimpan');
                    $('#screen-loader').attr('hidden', 'true')
                    $('#modal-assign-task').modal('hide');
                    $('#table-detail-tugas').DataTable().ajax.reload();
                },
                error : function (data) {
                    alertError(data.responseJSON.message);
                    $('#modal-assign-task').modal('hide');
                    $('#screen-loader').attr('hidden', 'true')
                }
            })
        })
    </script>
@endsection
