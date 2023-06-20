@extends('layouts.app')

@section('title')
<h4 class="rounded" style="color: #004A8E">My Dashboard</h4>

@endsection

@section('content')
<canvas id="myChart"></canvas>
<div class="text-center my-4">
    <h4 class="rounded" style="color: #004A8E">Tugasku</h4>
</div>
<div class="row d-flex justify-content-around">
    <div class="col-lg-3 mb-3">
        <div class="card border-0 shadow bg-primary text-white" style="border-radius: 8px">
            <div class="card-body">
               <h5>Submitted</h5>
               <p id="submitted">0</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 mb-3">
        <div class="card border-0 shadow bg-secondary text-white" style="border-radius: 8px">
            <div class="card-body">
                <h5>Unsubmitted</h5>
               <p id="unsubmitted">0</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 mb-3">
        <div class="card border-0 shadow bg-danger text-white" style="border-radius: 8px">
            <div class="card-body">
                <h5>Late</h5>
               <p id="late">0</p>
            </div>
        </div>
    </div>

</div>

@endsection


@section('script')

<script>
    const ctx = document.getElementById('myChart');
    var label = [];
    var nilai = [];



    var datas = {
    labels: label,
    datasets: [{
        label: 'Penugasan',
        data: nilai,
        fill: false,
        borderColor: 'rgb(75, 192, 192)',

    }]
    };

    const config = {
        type: 'line',
        data: datas,
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
            },
            }
        }
        };
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

    // $(document).ready(function () {
    // })


    var chart = new Chart(ctx, config)
    $(document).ready(function () {

        $.ajax({
            url : "/api/mahasiswa/dashboard",
            headers : {
                        'Authorization':  'Bearer ' + curCookie,
                    },
            type : "GET",
            success : function (data) {
                console.log(data);
                var res = data.data;
                var submitted = 0;
                var unsubmitted = 0 ;
                var late = 0;
                res.forEach(el => {
                    label.push(el.penugasan_kelas.penugasan.judul)
                    nilai.push(el.total_nilai)
                    console.log(datas);
                    data.labels = label
                    chart.update()
                    switch (el.status) {
                        case "unsubmitted":
                            unsubmitted++;
                            break;
                        case "submitted":
                            submitted++;
                            break;
                        case "late":
                            late++;
                            break;

                        default:
                            break;
                    }
// ctx.update()÷
                });
                $('#unsubmitted').html(unsubmitted)
                $('#submitted').html(submitted)
                $('#late').html(late)
            }
        })


    })
</script>

@endsection
