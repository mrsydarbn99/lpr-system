@extends('layout.app')

@section('content')
@php
   $i = 1;
@endphp

<div class="container-fluid">
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <!-- Table Section -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Plate Number</th>
                    <th scope="col">Time</th>
                    <th scope="col">Status</th>
                    <th scope="col">Type</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($model as $item)
                <tr>
                    <th scope="row">{{ $i++ }}</th>
                    <td>{{ $item->plate_num }}</td>
                    <td>{{ $item->time }}</td>
                    <td>
                        @if ($item->status == 'In')
                            <span class="badge text-bg-success fs-6">In</span>
                        @else
                            <span class="badge text-bg-danger fs-6">Out</span>
                        @endif
                    </td>
                    <td>
                        @if ($item->type == 'resident')
                            <span class="badge text-bg-primary fs-6">Resident</span>
                        @else
                            <span class="badge text-bg-secondary fs-6">Non-Resident</span>
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger text-white" data-toggle="modal" data-target="#deleteModal{{ $item->id }}">Delete</button>
                    </td>
                </tr>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Confirm Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete "{{ $item->name }}"?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <form action="{{ route('resident-delete', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Delete Modal -->
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
