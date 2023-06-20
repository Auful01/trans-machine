<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/5f712d1a25.js" crossorigin="anonymous"></script>
</head>
<body>
    <style>

    .btn-primary{
        background-color: #2A4222;
        border-color: #2A4222;
        box-shadow: 0 4px 8px 0 rgba(2, 124, 43, 0.2), 0 6px 20px 0 rgba(5, 118, 52, 0.19);
    }

    .btn-warning, .bg-warning{
        box-shadow: 0 4px 8px 0 rgba(250, 230, 12, 0.2), 0 6px 20px 0 rgba(219, 233, 17, 0.19);
    }

    .btn-primary:hover{
        background-color: #1b2a16;
        border-color: #1b2a16;
        box-shadow: 0 4px 8px 0 rgba(2, 124, 43, 0.2), 0 6px 20px 0 rgba(5, 118, 52, 0.19);
    }

         .btn-info {
        box-shadow: 0 4px 8px 0 rgba(0, 105, 185, 0.2), 0 6px 20px 0 rgba(1, 107, 255, 0.19);
    }
    .bg-info {
        box-shadow: 0 4px 8px 0 rgba(0, 105, 185, 0.2), 0 6px 20px 0 rgba(1, 107, 255, 0.19);
    }

    .bg-success , .btn-success {
        box-shadow: 0 4px 8px 0 rgba(3, 185, 0, 0.2), 0 6px 20px 0 rgba(26, 255, 1, 0.19);
    }

    .bg-danger, .btn-danger{
        box-shadow: 0 4px 8px 0 rgba(229, 52, 52, 0.2), 0 6px 20px 0 rgba(255, 2, 2, 0.19);
    }
    </style>

    <div class="text-center">
        <h1 class="text-center" style="margin-top: 200px; font-weight: 800">
            401 Unauthorized
        </h1>
        <small>You can't access this page, cause is not your role</small>
        <div class="d-flex mt-3 justify-content-center">
            <button class="btn btn-sm btn-primary py-0"><i class="fas fa-home"></i>&nbsp; Dashboard</button>&nbsp;
            <button class="btn btn-sm btn-danger py-0"><i class="fas fa-power-off"></i>&nbsp; Logout</button>
        </div>
    </div>

</body>
</html>
