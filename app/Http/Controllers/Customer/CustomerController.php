<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $total_tickets = Ticket::where('user_id',Auth::id())->count();
        $total_opened_tickets= Ticket::where('user_id',Auth::id())->where('status','opened')->count();
        $total_closed_tickets = Ticket::where('user_id',Auth::id())->where('status','closed')->count();
        return view('customer.index', compact('total_tickets','total_opened_tickets','total_closed_tickets'));
    }
}
