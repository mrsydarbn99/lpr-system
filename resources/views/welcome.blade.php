<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LPR System - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link href="{{ asset('assets/dist/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/dist/css/bootstrap.min.css') }}" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/dist/css/sb-admin-2.min.css') }}" rel="stylesheet">
  <style>
    body {
      background: #F8F9FA;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      text-align: center;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="text-center">
    <a href="{{ route('welcome') }}"><i class="fas fa-car fa-9x"></i></a>
  </div>
  <div class="text-center mb-3">
  </div>
  <h1 class="mb-4">Welcome to LPR System</h1>
  <div class="d-grid gap-2 col-6 mx-auto">
    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login</a>
    <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">Register Non-Resident</a>
  </div>
</div>

</body>
</html>
