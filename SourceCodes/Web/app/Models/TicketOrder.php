<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Order;

class TicketOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function orderData()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id')->select('id', 'order_details');
    }
}
