<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Event;
use App\Models\Admin\Ticket;

class AddToCart extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the event associated with the AddToCart
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function event()
    {
        return $this->hasOne(Event::class, 'id', 'event_id');
    }

    /**
     * Get the ticket associated with the AddToCart
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ticket()
    {
        return $this->hasOne(Ticket::class, 'id', 'ticket_id');
    }
}
