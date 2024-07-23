@extends('layout.app')

@section('content')

<div class="container">
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <strong>Welcome, {{ session('username') }}!</strong>

    <!-- Rest of your content here -->

    <br></br>

    <div class="row">
        <div class="col-xl-5 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Resident Registered</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $resident }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-5 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Non-Resident Registered</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $nonResident }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-solid fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-5 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Resident Entry
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $entryResidentCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-solid fa-arrow-circle-down fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-5 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Non-Resident Entry</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $entryNonResidentCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-solid fa-arrow-circle-down fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-5 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Resident Out</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $outResidentCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-solid fa-arrow-circle-up fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-5 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Non-Resident Out</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $outNonResidentCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-solid fa-arrow-circle-up fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





@endsection