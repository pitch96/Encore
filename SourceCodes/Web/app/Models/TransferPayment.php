<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Admin\Event;

class TransferPayment extends Model
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
     * Get the promoter associated with the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function promoter()
    {
        return $this->hasOne(User::class, 'id', 'promoter_id')->select('id', DB::raw("CONCAT(users.first_name,' ',users.last_name) AS full_name"));
    }

    /**
     * Get the admin associated with the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function admin()
    {
        return $this->hasOne(User::class, 'id', 'admin_id')->select('id', DB::raw("CONCAT(users.first_name,' ',users.last_name) AS full_name"));
    }
}
