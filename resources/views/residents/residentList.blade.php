@extends('layout.app')

@section('content')
@php
   $i = 1;
@endphp

<div class="container-fluid">
    <!-- Create Button -->
    <div class="mb-3">
        <a href="{{ route('resident-create') }}" class="btn btn-success" class="">Create New Resident</a>
    </div>

    <!-- Table Section -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Plate Number</th>
                    <th scope="col">Entry Time</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($model as $item)
                <tr>
                    <th scope="row">{{ $i++ }}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->phone_num }}</td>
                    <td>{{ $item->plate_num }}</td>
                    <td>{{ $item->entry_time }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Actions">
                            <a href="{{ route('resident-edit', $item->id) }}" class="btn btn-primary" style="margin-right: 10px">Edit</a>
                            <form action="{{ route('resident-delete', $item->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger text-white" onclick="return confirm('Confirm Delete?');">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
