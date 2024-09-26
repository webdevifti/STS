<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function customer(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function response(){
        return $this->hasMany(TicketResponse::class,'ticket_id','id');
    }
}
