@extends('layout.app')

@section('content')

<form action="{{ route('non-resident-store') }}" method="POST">
    @csrf
    
    @include('nonResidents.form')
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection