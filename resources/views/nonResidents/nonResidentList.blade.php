@extends('layout.app')

@section('content')

<div class="container-fluid">
    <!-- Create Button -->
    <div class="mb-3">
        <a href="{{ route('non-resident-create') }}" class="btn btn-success">Create New Non-Resident</a>
    </div>
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
                    <th scope="col">Name</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Plate Number</th>
                    <th scope="col">Time</th>
                    <th scope="col">Days</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($model as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->phone_num }}</td>
                    <td>{{ $item->plate_num }}</td>
                    <td>{{ $item->entry_time }}</td>
                    <td>{{ $item->days }}</td>
                    <td>
                        @if ($item->status == 'In')
                            <span class="badge text-bg-success fs-6">In</span>
                        @elseif ($item->status == 'Out')
                            <span class="badge text-bg-danger fs-6">Out</span>
                        @elseif ($item->status == 'New')
                            <span class="badge text-bg-primary fs-6">New</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Actions">
                            <a href="{{ route('non-resident-edit', $item->id) }}" class="btn btn-primary" style="margin-right: 10px">Edit</a>
                            <!-- Delete Modal Trigger Button -->
                            <button type="button" class="btn btn-danger text-white" data-toggle="modal" data-target="#deleteModal{{ $item->id }}">Delete</button>
                        </div>
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
                                <form action="{{ route('non-resident-delete', $item->id) }}" method="POST" style="display: inline;">
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
    <div class="d-flex justify-content-center">
        {{ $model->links('pagination::bootstrap-4') }}
    </div>
</div>


@endsection
