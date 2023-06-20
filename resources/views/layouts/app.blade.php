<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://kit.fontawesome.com/5f712d1a25.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<style>
     @font-face {
            font-family: 'rounded-mplus-1-black';
            src: url('{{asset('/RoundedMplus1c-Black.ttf')}}');
    }
    .rounded{
        font-family: 'rounded-mplus-1-black';
    }

    .blur{
        /* position: fixed;
        z-index:1; */
        width:100%;
        height: 80px;
        background: linear-gradient(90deg, #8dc8ff, #0084ffda ) ;
        backdrop-filter: blur(5px);
    }

    .bg-primary,.btn-primary {
        background: #004A8E;
        border: #004A8E;
    }

    .preloader{
        display: flex;
        background-color: #f4f6f994;
        backdrop-filter: blur(2px);
        min-height: 100vh;
        width: 100%;
        transition: height .2s linear;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 9999;
    }

</style>
{{-- <div style="height: 100vh">
</div> --}}
<body style="height: 100vh">

    <div class="preloader flex-column justify-content-center align-items-center" style="height: 0px;" id="screen-loader" hidden>
        @include('layouts.loading-screen')
    </div>
    <div id="wrapper">

        <!-- Sidebar -->
       @include('layouts.sidebar')
       @include('layouts.header')


        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container" style="margin-top: -35px;padding-bottom: 90px;">
                <div class="card border-0 shadow  mb-3" style="border-radius: 10px">
                    <div class="card-body py-3">
                        @yield('title')
                    </div>
                </div>

                <div class="card border-0 shadow" style="border-radius: 15px">
                    <div class="card-body">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>

        <button class="btn" style="position: fixed;right:30px;bottom:60px;border-radius: 30%;backdrop-filter: blur(10px);background: rgba(219, 251, 255, 0.404);">
            <i class="fas fa-chevron-up"></i>
        </button>

    </div>
    <div class="footer mt-4 shadow-sm" style="background: #8dc8ff52;position: fixed;bottom: 0;backdrop-filter:blur(5px); width: 100%;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="footer-p text-center pt-2">
                        <p>© {{\Carbon\Carbon::now()->year}} SIPELABA. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#wrapper -->


    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script type="module">
        // Import the functions you need from the SDKs you need
        import { initializeApp } from "https://www.gstatic.com/firebasejs/9.19.0/firebase-app.js";
        import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.19.0/firebase-analytics.js";
        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries

        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
          apiKey: "AIzaSyA6gtcAeTQp1eXTyo68hKWymyw_3ajfR1g",
          authDomain: "sipelaba.firebaseapp.com",
          projectId: "sipelaba",
          storageBucket: "sipelaba.appspot.com",
          messagingSenderId: "964372173098",
          appId: "1:964372173098:web:1f0c9fb06fbd85e1120e53",
          measurementId: "G-4TRD6K5DLN"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const analytics = getAnalytics(app);
      </script>
    <script>
        var dataDetail;
        var curCookie = Cookies.get('admin_cookie') ?? (Cookies.get('dosen_cookie') ?? Cookies.get('mahasiswa_cookie'));
        // console.log(curCookie);
        function getSegment() {
            return {{request()->segment(count(request()->segments()))}};
        }

        toBase64 = file => new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = error => reject(error);
            return reader;
        });

        function convertDate(el) {
                        const dateFormat = new Intl.DateTimeFormat('id-ID', {
                                dateStyle: 'full'
                        });

                        var date = new Date(el)
                        var returnDate = dateFormat.format(date);

                        return returnDate;
        }

        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
            if ($('.sidebar-lg').is(':hidden')) {
                $('.sidebar-lg').attr('hidden', false);
                $('.sidebar-sm').attr('hidden', true);
            } else {
                $('.sidebar-lg').attr('hidden', true);
                $('.sidebar-sm').attr('hidden', false);
            }
        });

        function getDetail(params) {
            var result;
            $.ajax({
                url : params,
                type : "GET",
                headers : {
                    'Authorization' : `Bearer ${curCookie}`
                },
                success : function(res) {
                     setDetail(res.data);
                },
            })
        }

        setDetail = (data) => {
            return dataDetail = data;
        }



        $(".nav-item").click(function(){
            $(".nav-item").removeClass("active");
            $(this).addClass("active");
        })

        function alertSuccess(msg) {
            Swal.fire({
                title : "Berhasil",
                icon: "success",
                text : msg,
                timer: 2000,
                showConfirmButton :false,
                timerProggressBar: true
            })
        }

        function alertError(msg) {
            Swal.fire({
                title : "Gagal",
                icon: "error",
                text : msg,
                timer: 2000,
                showConfirmButton :false,
                timerProggressBar: true
            })
        }

         function getUrlParam(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return false;
        };

        function RemoveLastDirectoryPartOf(the_url)
        {
            var the_arr = the_url.split('/');
            the_arr.pop();
            return( the_arr.join('/') );
        }

        $("body").on('click', '.btn-back', function () {
            window.location.href = RemoveLastDirectoryPartOf(window.location.href)
        })
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @yield('script')
</body>
</html>
