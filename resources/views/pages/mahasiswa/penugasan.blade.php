@extends('layouts.app')

@section('title')
<h4 class="rounded" style="color: #004A8E">Penugasan</h4>
@endsection
@section('content')
<div class="row d-flex" id="list-task">
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $.ajax({
            url : '/api/mahasiswa/penugasan',
            type : 'GET',
            headers : {
                'Authorization' : 'Bearer ' + Cookies.get('mahasiswa_cookie')
            },
            success : function (data) {
                console.log(data)
                $('#list-task').empty()
                if (data.data.length == 0) {
                    $('#list-task').append(`
                    <div class="mx-auto ">
                    <h4 class="text-center">Your Task Is Empty</h4>
                    <img class="img-fluid my-5" style="max-height:400px" src="${window.location.origin}/empty_task.png" alt="Empty Task - Illustration@pngkey.com">
                    </div>
                    `)
                }else{
                    data.data.forEach(el => {
                        var seconds = parseInt((el.tanggal_selesai-el.tanggal_mulai)/1000);

                        var returnDate = convertDate(el.tanggal_selesai)


                        // console.log(el.penugasan.judul);
                        $('#list-task').append(`<div class="col-md-3">
                            <a href="/mahasiswa/penugasan/${el.id}" class="mb-3 text-primary"  style="text-decoration: none" data-id="${el.id}">
                                <div class="card" style="border:none;border-radius:10px">
                                    <img src="https://images.unsplash.com/photo-1481887328591-3e277f9473dc?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2962&q=80" class="img-fluid" alt="" style="border-radius:5px 5px 0 0">
                                    <div class="card-body shadow p-3" style="border-radius:5px">
                                        <h4>
                                            ${el.judul}
                                        </h4>
                                        <span class="badge badge-pills ${el.status == 'submitted' ? 'badge-success' : (el.status == 'unsubmitted' ? 'badge-secondary' : 'badge-danger') }">${el.status == 'unsubmitted' || el.status == null ? 'unsubmitted' : el.status }</span>
                                        <br>
                                        <div class="pt-3">
                                        <small style="font-style:italic;font-size:10pt">Due date : </small>
                                        <br>
                                        <small style="font-style:italic;font-size:10pt">${returnDate}</small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>`)
                    });
                }
            }
        })

    })
</script>
@endsection
