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
                <a href="{{ route('customer.tickets.create') }}" class="btn btn-outline-primary btn-sm">Add New</a>
            </div>

        </div>

        <section class="section dashboard">
            <div class="row">
                @if ($customer_tickets->count() > 0)
                    @foreach ($customer_tickets as $ticket)
                        <div class="col-lg-4">
                            <a href="{{route('customer.tickets.show',$ticket->id)}}" class="">
                                <div class="card ticket-card">
                                    <div class="card-body p-2">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <button
                                                class="btn btn-outline-secondary btn-sm">{{ $ticket->category?->name }}</button>
                                            <div>
                                                <button class="btn btn-sm btn-{{$ticket->status === 'opened'?'success':'danger'}}">{{ucwords($ticket->status)}}</button>
                                                <strong>#{{ $ticket->ticket_number }}</strong>
                                            </div>
                                        </div>
                                        <h3 class="card-title">{{ $ticket->title }}</h3>
                                        <p>{{ $ticket->message }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="card">
                        <div class="card-body p-2">
                            <h3 class="card-title text-center ">No Ticket Created</h3>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>

@endsection
