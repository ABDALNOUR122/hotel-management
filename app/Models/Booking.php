<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
 protected $fillable = ['room_id', 'customer_id', 'check_in', 'check_out', 'total_days'];
public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

   public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
