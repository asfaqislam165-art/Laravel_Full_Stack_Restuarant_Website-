<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'customer_name', 'phone', 'email', 'reservation_date',
        'reservation_time', 'guests', 'special_requests', 'status'
    ];
    protected $casts = ['reservation_date' => 'date'];
}