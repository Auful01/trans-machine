<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <script src="https://kit.fontawesome.com/5f712d1a25.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
</head>
<body style="overflow: hidden;">

    <style>

    .txt-primary{
        color: #004A8E;
    }

    .bt-primary{
        background-color: #004A8E;
        color: #fff;
        box-shadow:  0 .5rem 1rem rgba(23, 133, 251, 0.15)!important;
    }

    .bt-primary:hover{
        background-color: #fff;
        color: #004A8E;
        box-shadow:  0 .5rem 1rem rgba(23, 133, 251, 0.15)!important;
    }

    @font-face {
            font-family: 'rounded-mplus-1-black';
            src: url('{{asset('/RoundedMplus1c-Black.ttf')}}');
    }

    .rounded{
        font-family: 'rounded-mplus-1-black';
    }

        .vertical-center {
        margin: 0;
        position: absolute;
        top: 45%;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        }


        #inner {
            height: 500px;
            width: 500px;
            background: linear-gradient(120deg, #67b6ff94,  #004A8E ) ;
            /* border-radius: 50%; */
            -moz-border-radius: 100px;
            -webkit-border-radius: 50%;
            margin-left: 90%;
            margin-top: 25%;
        }

        #inner-left {
            height: 400px;
            width: 400px;
            background: linear-gradient(120deg, #67b6ff94, #004A8E );
            /* border-radius: 50%; */
            -moz-border-radius: 100px;
            -webkit-border-radius: 50%;
            margin-left: 36%;
            margin-top: -78%;
        }

        #inner-left-mini {
            height: 100px;
            width: 100px;
            background: linear-gradient(120deg, #67b6ff94, #004A8E );
            /* border-radius: 50%; */
            -moz-border-radius: 100px;
            -webkit-border-radius: 50%;
            margin-left: 19%;
            margin-top: 10%;
        }

        .form-control {
            border: none;
            box-shadow:  3px 5px 7px 0rem rgb(0 123 255 / 25%);
        }

        .label-form {
            position: absolute;
            top: 90px;
            left: 32px;
            font-size: 13px;
            transition: all 0.3s ease-in-out;
            z-index: 100000;
        }

        .label-form.active {
            top: 60px;
            left: 20px;
            color: #000;
            font-size: 14px;
        }
        .label-form-password {
            position: absolute;
            top: 153px;
            left: 32px;
            font-size: 13px;
            transition: all 0.3s ease-in-out;
            z-index: 100000;
        }

        .label-form-password.active {
            top: 126px;
            left: 20px;
            color: #000;
            font-size: 14px;
        }

        .btn-primary, .btn-outline-primary:hover {
            background: linear-gradient(120deg, #67b6ff94,  #004A8E ) ;
            border: none;
        }

        .btn-outline-primary {
            border: 1px solid #004A8E ;
            color: #004A8E
        }



    </style>
    <div class="container">
        <div class="header py-3 rounded txt-primary" style="backdrop-filter: blur(5px)">
            UNIVERSITAS NEGERI JEMBER
        </div>
        <div class="vertical-center">
            <div class="row">
                <div class="col-md-4">
                    <h1 class="rounded txt-primary">
                        SISTEM PEMBELAJARAN LABORATORIUM BAHASA
                    </h1>
                </div>
                <div class="col-md-7">
                    <div class="card border-0 w-100" style="width: 400px;backdrop-filter: blur(5px);background: linear-gradient(120deg, #67b6ff41,  #fafafa93 );border-radius: 10px;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h3 class="rounded txt-primary">Register</h3>
                                <div class="btn-group btn-sm">
                                    <button class="btn btn-sm btn-primary" id="btn-mhs">Mahasiswa</button>
                                    <button class="btn btn-sm btn-outline-primary" id="btn-dosen">Dosen</button>
                                </div>
                            </div>
                            <div class="row d-flex">
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        <label for="" class="m-0" >Name</label>
                                        <input type="text" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group" >
                                        <label for="" class="m-0">Email</label>
                                        <input type="password" class="form-control form-pw form-control-sm">
                                    </div>
                                    <div class="form-group" >
                                        <label for="" class="m-0" >Password</label>
                                        <input type="password" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group" >
                                        <label for="" class="m-0" >Confirm Password</label>
                                        <input type="password" class="form-control form-pw form-control-sm">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        <label for="" class="m-0" >Nomer Identitas</label>
                                        <input type="text" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group" >
                                        <label for="" class="m-0" >Kelas</label>
                                        <select name="" id="kelas" class="form-control form-pw form-control-sm" ></select>
                                    </div>
                                    <div class="form-group" >
                                        <label for="" class="m-0" >Fakultas</label>
                                        <input type="text" class="form-control form-pw form-control-sm" id="fakultas">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex py-3 justify-content-end">
                                <a class="btn btn-sm btn-light shadow" href="/login">
                                    {{-- <span class="material-symbols-outlined" style="font-size: 14px">
                                        person_add
                                        </span> --}}
                                        <i class="fas fa-sign-in-alt"></i>
                                        Login</a>&nbsp;
                                        <a class="btn btn-sm bt-primary my-auto" href="/sign-up">
                                            {{-- <span class="material-symbols-outlined m-sm-0" style="font-size: 14px">
                                                login
                                            </span>  --}}
                                            <i class="fas fa-user-plus"></i>
                                    Register</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="inner">
        </div>
        <div id="inner-left">
        </div>
        <div id="inner-left-mini">
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script>
        $(document).ready(function () {
            $.ajax({
                url : '/api/kelas',
                type : 'GET',
                success : function (data) {
                    var kelas = data.data;
                    $('#kelas').append(new Option("-- Pilih Kelas --"))
                    kelas.forEach(el => {
                        $('#kelas').append(new Option(el.name,el.id))
                    });
                }
            })
        })

        $('#btn-mhs').on('click', function () {
            $('#btn-dosen').removeClass('btn-primary').addClass('btn-outline-primary')
            $('#btn-mhs').removeClass('btn-outline-primary').addClass('btn-primary')
            $('#faculty').closest('div').attr('hidden', false)
            $('#kelas').closest('div').attr('hidden', false)
        })
        $('#btn-dosen').on('click', function () {
            $('#btn-mhs').removeClass('btn-primary').addClass('btn-outline-primary')
            $('#btn-dosen').removeClass('btn-outline-primary').addClass('btn-primary')
            $('#faculty').closest('div').attr('hidden', true)
            $('#kelas').closest('div').attr('hidden', true)
        })

        $('.form-control').on('focus', function(){
            $(this).parent().find('.label-form').addClass('active');
        });

        $('.form-control').on('blur', function(){
            if($(this).val() == ''){
                $(this).parent().find('.label-form').removeClass('active');
            }
        });

        $('.form-pw').on('focus', function(){
            $(this).parent().find('.label-form-password').addClass('active');
        });

        $('.form-pw').on('blur', function(){
            if($(this).val() == ''){
                $(this).parent().find('.label-form-password').removeClass('active');
            }
        });
    </script>

</body>
</html>
