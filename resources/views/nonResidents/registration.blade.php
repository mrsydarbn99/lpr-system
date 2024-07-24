<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LPR System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <style type="text/css">
    body {
      background: #F8F9FA;
    }
  </style>
</head>
<body>

<section class="bg-light py-3 py-md-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <div class="card border border-light-subtle rounded-3 shadow-sm">
          <div class="card-body p-3 p-md-4 p-xl-5">
            <div class="text-center mb-3">
            </div>
            <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Register Non-Resident Plate Number</h2>
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('non-resident-store') }}">
              @csrf

              @if (session('error'))
                  <div class="alert alert-danger" role="alert"> 
                      {{ session('error') }}
                  </div>
              @endif

              <div class="row gy-2 overflow-hidden">
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                  </div>
                  @error('name')
                        <span class="text-danger" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('phone_num') is-invalid @enderror" name="phone_num" id="phone_num" placeholder="Phone Number">
                    <label for="phone_num" class="form-label">{{ __('Phone Number') }}</label>
                  </div>
                  @error('phone_num')
                        <span class="text-danger" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('plate_num') is-invalid @enderror" name="plate_num" id="plate_num" placeholder="Plate Number">
                    <label for="plate_num" class="form-label">{{ __('Plate Number') }}</label>
                  </div>
                  @error('plate_num')
                      <span class="text-danger" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="col-12">
                    <select class="form-select @error('days') is-invalid @enderror mb-3" aria-label="Default select example" name="days" id="days">
                        <option selected>Days</option>
                        @for ($i = 1; $i < 8; $i++)
                          <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                  @error('days')
                      <span class="text-danger" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="col-12">
                  <div class="d-grid my-3">
                    <button class="btn btn-primary btn-lg" type="submit">{{ __('Register') }}</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</body>
</html>
