@extends('layouts.master')
@section('title', 'My Tickets')
@section('main_content')
    <main id="main" class="main">

        <div class="pagetitle">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1>My Tickets</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">My Tickets</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-primary btn-sm">All Tickets</a>

                    <button data-bs-target="#statusConfirmation" data-bs-toggle="modal"
                        data-content='{{ json_encode($ticket) }}' {{ $ticket->status == 'closed' ? 'disabled':'' }} class="btn btn-outline-success btn-sm statusBtn">Status
                        Update</button>
                    <button data-bs-target="#delete" data-bs-toggle="modal" data-content="{{ $ticket->id }}"
                        class="btn btn-outline-danger btn-sm">Delete</button>
                </div>
            </div>

        </div>

        <section class="section dashboard">
            <div class="row">

                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body p-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <button class="btn btn-outline-secondary btn-sm">{{ $ticket->category->name }}</button>
                                <div>
                                    <button
                                        class="btn btn-sm btn-{{ $ticket->status === 'opened' ? 'success' : 'danger' }}" >{{ ucwords($ticket->status) }}</button>
                                    <strong>#{{ $ticket->ticket_number }}</strong>
                                </div>
                            </div>
                            @php
                                $labels = json_decode($ticket->labels);
                            @endphp
                            @foreach ($labels as $label)
                                <span class="badge bg-info">{{ $label }}</span>
                            @endforeach
                            <h3 class="card-title">{{ $ticket->title }}</h3>
                            <p>{{ $ticket->message }}</p>

                           
                            @php
                               $files = !empty($ticket->files_attachments) ? json_decode($ticket->files_attachments, true) : [];
                            @endphp
                            @if (is_array($files))
                            <hr>
                            <h3 class="card-title">Files Attachments</h3>
                            @foreach ($files as $file)
                                <a href="{{ asset('storage/uploads/files/' . $file['img_name']) }}">
                                    <img width="100" height="100"
                                        src="{{ asset('storage/uploads/files/' . $file['img_name']) }}"
                                        class="img-fluid rounded" alt="">
                                </a>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-header">
                            <h3 class="card-title">Responds</h3>
                        </div>
                        <div class="card-body">
                            @foreach ($ticket->response as $responds)
                                @if ($responds->user_id == Auth::id())
                                    <strong>You: </strong>
                                @else 
                                    <strong>{{$ticket->customer?->name}}:</strong>
                                @endif
                                <p>{{ $responds->message }}</p>
                            @endforeach
                        </div>
                    </div>
                    @if($ticket->status != 'closed')
                    <div class="card mt-2">
                        <div class="card-header">
                            <h3 class="card-title">Send Responds</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.tickets.response', $ticket->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{base64_encode(Auth::id())}}">
                                <div class="mb-2">
                                    <label for="">Respond Message</label>
                                    <textarea name="respond_message" id="respond_message" cols="30" rows="5" class="form-control"
                                        placeholder="Message"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </form>
                        </div>
                    </div>
                    @endif

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
