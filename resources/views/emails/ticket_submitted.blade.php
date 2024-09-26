@component('mail::message')
# New Ticket Submitted

A new ticket has been submitted by {{ $ticket->customer->name }}.

**Ticket Number:** #{{ $ticket->ticket_number }}  
**Title:** {{ $ticket->title }}  
**Priority:** {{ ucwords($ticket->priority) }}  
**Category:** {{ $ticket->category->name }}  

@component('mail::button', ['url' => route('admin.tickets.show', $ticket->id)])
View Ticket
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
