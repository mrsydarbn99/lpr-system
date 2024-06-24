{{-- @extends('layout.app')

@section('content')


<table class="table">
    <div class="container-fluid">
      <!-- ============================================================== -->
      <!-- Start Page Content -->
      <!-- ============================================================== -->
      <div class="container">
        <h2>Upload a Video</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    {{-- @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach --}}
                {{-- </ul>
            </div>
        @endif
    
        <form action="{{ route('upload.video') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="input-group">
                <input type="file" class="form-control" id="video" aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="video">
                <button class="btn btn-outline-secondary" type="submit" id="submit">Submit</button>
            </div>
        </form> --}}
    
        {{-- @if (isset($output))
            <h3>Output:</h3>
            <pre>{{ $output }}</pre>
            <img src="{{ asset('storage/' . $path) }}" alt="Uploaded Photo" class="img-fluid">
        @endif --}}
    {{-- </div>
    </div>
</table>

@endsection --}}

@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="container">
        <h2>Scan for Vehicles</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('message'))
            <div class="alert alert-info">
                {{ session('message') }}
            </div>
        @endif

        <button class="btn btn-outline-secondary" id="scan">Scan</button>
        <button class="btn btn-outline-danger" id="stop">Stop</button>

        @if (isset($output))
            <h3>Output:</h3>
            @if ($carInDatabase)
                <div class="alert alert-success">
                    Vehicle found in the database!
                </div>
                @if (isset($latestImagePath))
                    <img src="{{ asset($latestImagePath) }}" alt="Detected Frame" class="img-fluid">
                @endif
            @else
                @if ($timeout)
                    <div class="alert alert-danger">
                        Timeout: Vehicle not found in the database within the expected time.
                    </div>
                @else
                    <div class="alert alert-danger">
                        Vehicle not found in the database.
                    </div>
                    <pre>{{ $output }}</pre>
                @endif
            @endif
        @endif
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#scan').click(function() {
            $.ajax({
                url: '{{ route('scan.video') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert('Scan started.');
                    location.reload();
                },
                error: function(response) {
                    alert('Failed to start the scan.');
                }
            });
        });

        $('#stop').click(function() {
            $.ajax({
                url: '{{ route('stop.scan') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert('Scan stopped.');
                    location.reload();
                },
                error: function(response) {
                    alert('Failed to stop the scan.');
                }
            });
        });
    });
</script>
@endsection
