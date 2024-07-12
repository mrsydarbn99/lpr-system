@extends('layout.app')

@section('content')

<form action="{{ route('user-update',$model->id) }}" method="POST">
    @csrf
    @method('put')
    @include('users.form')
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection