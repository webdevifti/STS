@extends('layouts.master')
@section('title', 'Customers')
@section('main_content')
    <main id="main" class="main">

        <div class="pagetitle">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1>Manage Customer</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Customers</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="table-responsive">
                    <table class="table" ">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Ticket Count</th>
                            <th>Joined At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                         @foreach ($customers as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->tickets->count() }}</td>
                           
                            <td>{{ date('d M Y', strtotime($item->created_at)) }}</td>
                            <td>
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
        $('.deleteBtn').click(function() {
            var modal = $('#delete');
            var content = $(this).data('content');
            var form_action = "{{ route('admin.customers.destroy', ':contentId') }}";
            form_action = form_action.replace(':contentId', content.id);
            modal.find('#formDelete').attr('action', form_action);
            modal.modal('show');
        });
    </script>
@endsection
