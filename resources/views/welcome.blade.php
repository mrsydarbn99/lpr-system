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
</div>

@endsection