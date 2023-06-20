@extends('layouts.app')

@section('title')
<h4 class="rounded" style="color: #004A8E">Dashboard</h4>

@endsection

@section('content')
{{-- <canvas id="myChart"></canvas>
<div class="text-center my-4">
    <h4 class="rounded" style="color: #004A8E">Summary</h4>
</div> --}}
<div class="row">
    <div class="col-lg-3 mb-3">
        <div class="card border-0 shadow bg-primary text-white" style="border-radius: 8px">
            <div class="card-body">
               <h5>User</h5>
               <p id="total-user">0</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 mb-3">
        <div class="card border-0 shadow bg-info text-white" style="border-radius: 8px">
            <div class="card-body">
                <h5>Kelas</h5>
               <p id="total-kelas">0</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 mb-3">
        <div class="card border-0 shadow bg-success text-white" style="border-radius: 8px">
            <div class="card-body">
                <h5>Dosen</h5>
               <p id="total-dosen">0</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 mb-3">
        <div class="card border-0 shadow bg-danger text-white" style="border-radius: 8px">
            <div class="card-body">
                <h5>Mahasiswa</h5>
                <p id="total-mhs"0</p>
            </div>
        </div>
    </div>
</div>

@endsection


@section('script')

<script>
    var totalUser = 0;

    function animate(length, id) {
        var i = 1
        var response = 200;
        setInterval(() => {
        if (i <= length) {
                $(id).html(i);
                i++
            }else{
                $(id).html(length);
            }
        }, (i / length) * response);

    }

    function getUser(){
        $.ajax({
            url: '/api/user',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                totalUser = response.data;
                animate(response.data.length,'#total-user')
            }
        });
    }

    function getKelas() {
        $.ajax({
            url: '/api/kelas',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                animate(response.data.length, '#total-kelas')
            }
        });
    }

    function getDosen() {
        $.ajax({
            url: '/api/dosen',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                animate(response.data.length, '#total-dosen')
            }
        });
    }

    function getMahasiswa() {
        $.ajax({
            url: '/api/mahasiswa',
            headers : {
                'Authorization' : 'Bearer ' + curCookie
            },
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                animate(response.data.length, '#total-mhs')
            }
        });
    }

    $(document).ready(function () {
        getUser()
        getKelas()
        getDosen()
        getMahasiswa()

    })

    const ctx = document.getElementById('myChart');



    const data = {
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [{
        label: 'Looping tension',
        data: [65, 59, 80, 81, 26, 55, 40],
        fill: false,
        borderColor: 'rgb(75, 192, 192)',
    }]
    };

    const config = {
        type: 'line',
        data: data,
        options: {
            animations: {
            tension: {
                duration: 1000,
                easing: 'linear',
                from: 1,
                to: 0,
                loop: true
            }
            },
            scales: {
            y: { // defining min and max so hiding the dataset does not change scale range
                min: 0,
                max: 100
            }
            }
        }
        };

    // const labels = Utils.months({count: 7});
    // const data = {
    // labels: ['Red', 'Orange', 'Yellow', 'Green', 'Blue', 'Purple', 'Grey'],
    // datasets: [{
    //     label: 'My First Dataset',
    //     data: [65, 59, 80, 81, 56, 55, 40],
    //     backgroundColor: [
    //     'rgba(255, 99, 132, 0.2)',
    //     'rgba(255, 159, 64, 0.2)',
    //     'rgba(255, 205, 86, 0.2)',
    //     'rgba(75, 192, 192, 0.2)',
    //     'rgba(54, 162, 235, 0.2)',
    //     'rgba(153, 102, 255, 0.2)',
    //     'rgba(201, 203, 207, 0.2)'
    //     ],
    //     borderColor: [
    //     'rgb(255, 99, 132)',
    //     'rgb(255, 159, 64)',
    //     'rgb(255, 205, 86)',
    //     'rgb(75, 192, 192)',
    //     'rgb(54, 162, 235)',
    //     'rgb(153, 102, 255)',
    //     'rgb(201, 203, 207)'
    //     ],
    //     borderWidth: 1
    // }]
    // };

    // const config = {
    //     type: 'bar',
    //     data: data,
    //     options: {
    //         scales: {
    //         y: {
    //             beginAtZero: true
    //         }
    //         }
    //     },
    //     };

    $(document).ready(function () {
        new Chart(ctx, config)
    })


</script>

@endsection
