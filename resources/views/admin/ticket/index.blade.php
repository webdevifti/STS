@extends('layouts.master')
@section('title', 'Tickets')
@section('main_content')
    <main id="main" class="main">

        <div class="pagetitle">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1>Tickets</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tickets</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>

        <section class="section dashboard">
            <div class="row">

                <form action="{{ route('admin.tickets.index') }}" method="GET">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control" placeholder="Search by Title or Number"
                                value="{{ request()->search }}">
                        </div>
                        <div class="col-md-3">
                            <select name="category" class="form-control">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request()->category == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="priority" class="form-control">
                                <option value="">All Priorities</option>
                                <option value="low" {{ request()->priority == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ request()->priority == 'medium' ? 'selected' : '' }}>Medium
                                </option>
                                <option value="high" {{ request()->priority == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-control">
                                <option value="">All Statuses</option>
                                <option value="opened" {{ request()->status == 'opened' ? 'selected' : '' }}>Opened</option>
                                <option value="closed" {{ request()->status == 'closed' ? 'selected' : '' }}>Closed
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table">
                        @if ($tickets->count() > 0)
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Priority</th>
                                    <th>Title</th>
                                    <th>Customer</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($tickets as $item)
                                    <tr>
                                        <td><a
                                                href="{{ route('admin.tickets.show', $item->id) }}">#{{ $item->ticket_number }}</a>
                                        </td>
                                        <td>{{ ucwords($item->priority) }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->customer?->name }}</td>
                                        <td>{{ $item->category?->name }}</td>
                                        <td>
                                            @if ($item->status == 'opened')
                                            @php
                                                $disable = false;
                                            @endphp
                                                <span class="badge bg-success">
                                                    Opened
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    Closed
                                                </span>
                                                @php
                                                $disable = true;
                                            @endphp
                                            @endif

                                        </td>
                                        <td>{{ date('d M Y', strtotime($item->created_at)) }}</td>
                                        <td>
                                            <button data-content='{{ json_encode($item) }}' data-bs-toggle="modal"
                                                data-bs-target="#statusConfirmation"
                                                class="btn btn-{{ $item->status == 'opened' ? 'success' : 'danger' }} btn-sm statusBtn"  {{$disable ? 'disabled':'' }}>Update
                                                Status</button>
                                            <a href="{{ route('admin.tickets.show', $item->id) }}"
                                                class="btn btn-outline-primary btn-sm">View</a>

                                            <button data-bs-toggle="modal" data-bs-target="#delete"
                                                data-content='{{ json_encode($item) }}'
                                                class="btn btn-sm btn-outline-danger deleteBtn">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        @else
                            <div class="card">
                                <div class="card-body p-2">
                                    <h3 class="card-title text-center ">No Ticket Found</h3>
                                </div>
                            </div>
                        @endif
                    </table>
                    {!! $tickets->appends(request()->query())->links() !!}
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
    
    {{-- Status Confirm --}}
    <div class="modal" id="statusConfirmation" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="statusConfirmationLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Update Status</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formStatus">
                        @csrf
                        <div>
                            <label for="">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="opened">Opened</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer text-end">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">No</button>
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
            var form_action = "{{ route('admin.tickets.destroy', ':contentId') }}";
            form_action = form_action.replace(':contentId', content.id);
            modal.find('#formDelete').attr('action', form_action);
            modal.modal('show');
        });

        $('.statusBtn').click(function() {
            var modal = $('#statusConfirmation');
            var content = $(this).data('content');
            modal.find('#status').val(content.status);
            var form_action = "{{ route('admin.tickets.update.status', ':contentId') }}";
            form_action = form_action.replace(':contentId', content.id);
            modal.find('#formStatus').attr('action', form_action);
            modal.modal('show');
        });
    </script>
@endsection
