<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketStoreRequest;
use App\Mail\TicketSubmitted;
use App\Models\Category;
use App\Models\Label;
use App\Models\Ticket;
use App\Models\TicketResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customer_tickets = Ticket::with('category')->where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('customer.ticket.index', compact('customer_tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $labels = Label::where('status', 1)->get();
        $categories = Category::where('status', 1)->get();
        return view('customer.ticket.create', compact('labels', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketStoreRequest $request)
    {
        try {
            $ticket_number = rand(111111, 999999);
            $images = multipleFileUpload($request, 'uploads/files/', 'image');
            $ticket = Ticket::create([
                'ticket_number' => $ticket_number,
                'user_id' => Auth::user()->id,
                'category_id' => $request->category,
                'title' => $request->title,
                'message' => $request->message,
                'labels' => json_encode($request->label),
                'files_attachments' => json_encode($images),
                'priority' => $request->priority,
            ]);

            Mail::to(config('mail.admin_address'))->send(new TicketSubmitted($ticket));

            return back()->with('success', 'Ticket has been submitted successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to submit');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket = Ticket::with(['category'])->where('id', $id)->first();
        // dd($ticket);
        if (!$ticket) {
            return abort(404);
        }
        return view('customer.ticket.show', compact('ticket'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            $ticket->delete();
            return redirect()->route('customer.tickets.index')->with('success', 'Deleted successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to delete');
        }
    }

    public function respond(Request $request, $id){
        try{
            TicketResponse::create([
                'ticket_id' => $id,
                'user_id' => base64_decode($request->user_id),
                'message' => $request->respond_message
            ]);
            return back()->with('success','Reply sended successfully.');
        }catch(Exception $e){
            return back()->with('error','Failed to sent respond');
        }
    }
}
