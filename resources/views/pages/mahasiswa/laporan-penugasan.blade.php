@extends('layouts.app')

@section('title')
    <h4 class="rounded" style="color: #004A8E">Laporan penugasan</h4>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table" id="laporan-penugasan-table">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

@endsection


@section('script')
<script>
    var topik_id = $()
    $('#laporan-penugasan-table').DataTable({
        serverSide : false,
        processing : true,
        ajax :{
            url : "/api/mahasiswa/penugasan/laporan",
            type : "GET",
            headers : {
                'Authorization' : 'Bearer ' + curCookie
            }
        },
        columns : [
            {data : 'id',
            render : function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
            },
            {data : 'penugasan_kelas.penugasan.judul', name : 'judul'},
            {data : 'status', name : 'status'},
            {
                data : "total_nilai",
                render : function (data, row, type) {
                    return data.toFixed(2)
                }
            }
        ]
    })
</script>

@endsection
