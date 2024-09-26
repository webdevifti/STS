<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TicketClosed;
use App\Mail\TicketClosedMail;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\TicketResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tickets = Ticket::query();
        if ($request->has('search') && $request->search) {
            $tickets->where('title', 'like', '%' . $request->search . '%')->orWhere('ticket_number', 'like', '%' . $request->search . '%');
        }
        if ($request->has('category') && $request->category) {
            $tickets->where('category_id', $request->category);
        }
        if ($request->has('priority') && $request->priority) {
            $tickets->where('priority', $request->priority);
        }
        if ($request->has('status') && $request->status) {
            $tickets->where('status', $request->status);
        }
        $categories = Category::where('status', 1)->get();
        $tickets = $tickets->with(['category', 'customer', 'response'])->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.ticket.index', compact('tickets', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket = Ticket::with(['category', 'customer', 'response'])->where('id', $id)->first();
        // dd($ticket);
        if (!$ticket) {
            return abort(404);
        }
        return view('admin.ticket.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            $ticket->delete();
            return redirect()->route('admin.tickets.index')->with('success', 'Deleted successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to delete');
        }
    }
    public function updateStatus(Request $request, string $id)
    {
        try {
            $row = Ticket::findOrFail($id);
            if($request->status === 'closed'){
                Mail::to($row->customer->email)->send(new TicketClosed($row));
            }
            $row->status = ($row->status == 'opened') ? 'closed' : 'opened';
            $row->save();
            return back()->with('success', 'Status has been updated successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to update status.');
        }
    }

    public function respond(Request $request, $id)
    {
        try {
            TicketResponse::create([
                'ticket_id' => $id,
                'user_id' => base64_decode($request->user_id),
                'message' => $request->respond_message
            ]);
            return back()->with('success', 'Response sended successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to sent respond');
        }
    }
}
