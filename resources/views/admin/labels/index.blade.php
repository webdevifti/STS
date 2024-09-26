@extends('layouts.master')
@section('title', 'Labels')
@section('main_content')
    <main id="main" class="main">

        <div class="pagetitle">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1>Labels</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Labels</li>
                        </ol>
                    </nav>
                </div>
                <button type="button" data-bs-toggle="modal" data-bs-target="#createModal"
                    class="btn btn-outline-primary btn-sm">Add New</button>
            </div>

        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="table-responsive">
                    <table class="table" ">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                         @foreach ($labels as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>
                                @if ($item->status == 1)
                                    <span class="badge bg-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Inactive
                                    </span>
                                @endif

                            </td>
                            <td>{{ date('d M Y', strtotime($item->created_at)) }}</td>
                            <td>
                                <button data-content='{{ json_encode($item) }}' data-bs-toggle="modal"
                                    data-bs-target="#statusConfirmation"
                                    class="btn btn-{{ $item->status == 1 ? 'success' : 'danger' }} btn-sm statusBtn">Update Status</button>

                                <button data-bs-toggle="modal" data-bs-target="#edit"
                                    data-content='{{ json_encode($item) }}' class="btn btn-sm btn-info editBtn">Edit</button>

                                <button data-bs-toggle="modal" data-bs-target="#delete"
                                    data-content='{{ json_encode($item) }}'
                                    class="btn btn-sm btn-outline-danger deleteBtn">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
    {{-- Create Moda --}}
    <div class="modal" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="modalcontent">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.labels.store') }}">
                        @csrf
                        <div class="mb-2">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Name"
                                required>
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="modalcontent">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formUpdate" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-2">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Status Confirm --}}
    <div class="modal" id="statusConfirmation" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="statusConfirmationLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Confirmation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 id="confirmationTitle"></h5>
                    <p id="confirmationMessage"></p>
                </div>
                <div class="modal-footer text-end">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">No</button>
                    <a class="btn btn-danger" id="confirmBtn"> Yes</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div class="modal" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="modalcontent">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to delete.Remeber it will be undone</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">No</button>
                    <form method="POST" id="formDelete">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('.editBtn').click(function() {
            var modal = $('#edit');
            var content = $(this).data('content');
            var form_action = "{{ route('admin.labels.update', ':contentId') }}";
            form_action = form_action.replace(':contentId', content.id);
            modal.find('#formUpdate').attr('action', form_action);
            modal.find('#name').val(content.name);
    
            modal.modal('show');
        });
        $('.statusBtn').click(function() {
            var modal = $('#statusConfirmation');
            var content = $(this).data('content');
            var status_action = modal.find('#confirmBtn');
            var action = "{{ route('admin.label.update.status', ':contentId') }}";
            action = action.replace(':contentId', content.id);
            status_action.attr('href', action);

            var confirmationTitle = modal.find('#confirmationTitle');
            var confirmationMessage = modal.find('#confirmationMessage');
            if (content.status == 1) {
                confirmationTitle.text('Are you sure to inactive?');
                confirmationMessage.text(
                    'Once you inactive the item, it will not appear anywhere. But you will be able to enable the item again.'
                );
            } else {
                confirmationTitle.text('Are you sure to active?');
                confirmationMessage.text(
                    'If you active the item, it will appear everywhere. But you will be able to inactive the item again.'
                );
            }
            modal.modal('show');
        });

        $('.deleteBtn').click(function() {
            var modal = $('#delete');
            var content = $(this).data('content');
            var form_action = "{{ route('admin.labels.destroy', ':contentId') }}";
            form_action = form_action.replace(':contentId', content.id);
            modal.find('#formDelete').attr('action', form_action);
            modal.modal('show');
        });
    </script>
@endsection
