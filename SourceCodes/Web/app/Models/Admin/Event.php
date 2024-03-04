<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    /**
     * Get the category associated with the Event
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    /**
     * Get the user that owns the PromoterAccess
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->BelongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function scopeDashboardEvents($query)
    {
        $date = Carbon::parse(Carbon::now())->toDateString();
        $time = Carbon::parse(Carbon::now())->toTimeString();
        return $query->whereDate('end_date', '>', $date)->where('status', 1)
        ->where('isCancelled', 0)
        ->orWhere(function ($query) use ($date, $time) {
            $query->whereDate('end_date', '=', $date)
            ->whereTime('end_time', '>', $time)
            ->where('isCancelled', 0);
        });
    }

    public function scopeAllEvents($query)
    {
        $date = Carbon::parse(Carbon::now())->toDateString();
        $time = Carbon::parse(Carbon::now())->toTimeString();
        return $query->whereDate('end_date', '>', $date)
        ->orWhere(function ($query) use ($date, $time) {
            $query->whereDate('end_date', '=', $date)
            ->whereTime('end_time', '>', $time);
        });
    }


    /**
     * Get all of the promotional event for the Event
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function promotionalEvent()
    {
        return $this->hasMany(PromoterAccess::class, 'event_id', 'id')->where('status', 1);
    }

    /**
     * Get all of the promotional event for the Event
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function promoterRequestResponse()
    {
        return $this->hasOne(PromoterAccess::class, 'event_id', 'id')->select('event_id', 'status', 'verifiedPromoterEvent');
    }

    /**
     * Get all of the tickets for the Event
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'event_id', 'id');
    }
}
