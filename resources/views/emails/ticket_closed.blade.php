@component('mail::message')
# Ticket Closed

Hello {{ $ticket->customer->name }},

Your ticket (Ticket Number: #{{ $ticket->ticket_number }}) titled "{{ $ticket->title }}" has been closed.

**Priority:** {{ ucwords($ticket->priority) }}  
**Category:** {{ $ticket->category->name }}  
**Status:** Closed  

@component('mail::button', ['url' => route('customer.tickets.show', $ticket->id)])
View Ticket
@endcomponent

Thank you for using our support system.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
