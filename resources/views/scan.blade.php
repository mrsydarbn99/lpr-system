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
<table class="table">
    <div class="container-fluid">
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('scan-video') }}" method="POST">
                @csrf
                <button class="btn btn-info" type="submit" id="scan">Scan</button>
            </form>

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
                    <div class="alert alert-danger">
                        Vehicle not found in the database.
                    </div>
                @endif
            @endif
        </div>
    </div>
</table>
@endsection
