@extends('layout.app')

@section('content')

<form action="{{ route('resident-store') }}" method="POST">
    @csrf
    
    @include('residents.form')
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection