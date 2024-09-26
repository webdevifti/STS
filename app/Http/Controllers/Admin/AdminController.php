<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $total_tickets = Ticket::count();
        $total_customer = User::where('user_type','customer')->count();
        $total_categories = Category::count();
        $total_opened_tickets= Ticket::where('status','opened')->count();
        $total_closed_tickets = Ticket::where('status','closed')->count();
        return view('admin.index',compact('total_tickets','total_customer','total_closed_tickets','total_opened_tickets','total_categories'));
    }
}
