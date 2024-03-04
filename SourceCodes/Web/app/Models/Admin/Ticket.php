<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin\Category;
use Carbon\Carbon;

class Ticket extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    /**
     * Get the Event associated with the Ticket
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function event()
    {
        return $this->hasOne(Event::class, 'id', 'event_id');
    }

    public function scopeActiveTicket($query)
    {
        $date = Carbon::parse(Carbon::now())->toDateString();
        $time = Carbon::parse(Carbon::now())->toTimeString();
        return $query->whereDate('end_date', '>', $date)->where('status', 1)
        ->orWhere(function ($query) use ($date, $time) {
            $query->whereDate('end_date', '=', $date)
            ->whereTime('end_time', '>', $time);
        });
    }
}
