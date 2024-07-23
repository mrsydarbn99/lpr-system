<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LPR System - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
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
  <h1 class="mb-4">Welcome to LPR System</h1>
  <div class="d-grid gap-2 col-6 mx-auto">
    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login</a>
    <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">Register Non-Resident</a>
  </div>
</div>

</body>
</html>
