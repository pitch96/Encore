<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoterAccess extends Model
{
    use HasFactory;
    protected $guarded = [];
    

    /**
     * Get the events that owns the PromoterAccess
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function events()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    /**
     * Get the user that owns the PromoterAccess
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function promoter()
    {
        return $this->belongsTo(\App\Models\User::class, 'promoter_id', 'id');
    }

    /**
     * Get the user that owns the PromoterAccess
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function eventCreateBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'event_created_by', 'id');
    }
}
