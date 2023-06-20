@extends('layouts.app')

@section('title')
    <h4 class="rounded" style="color: #004A8E">My Profile</h4>
@endsection

@section('content')
<style>

    td {
        border: none !important
    }
</style>
    <div class="d-flex row">
        <div class="col-md-6">
            <table class="table border-0">
                <tr>
                    <td>Nama</td>
                    <td id="nama"></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td id="email"></td>
                </tr>
                <tr>
                    <td>ID Number</td>
                    <td id="id_num"></td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            Form
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $.ajax({
            url : "/api/profile",
            type : "GET",
            headers : {
                "Authorization" : "Bearer " + curCookie
            },
            success : function(data) {
                var res = data.data
                $('#nama').html(res.name)
                $('#email').html(res.email)
                $('#id_num').html(res.identity_num)
            }
        })
    })
</script>

@endsection
