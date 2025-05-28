<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    
    
    protected $fillable = [
        'title',
        'description',
        'category',
        'start_datetime',
        'end_datetime',
        'location',
        'max_participants',
        'remaining_quota',
        'ticket_price',
        'is_active',
        'created_by'
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
    ];

    // Relation avec l'administrateur créateur
    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by');
        //
}
}
