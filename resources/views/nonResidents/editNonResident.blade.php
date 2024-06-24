@extends('layout.app')

@section('content')

<form action="{{ route('non-resident-update',$model->id) }}" method="POST">
    @csrf
    @method('put')
    @include('nonResidents.form')
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection