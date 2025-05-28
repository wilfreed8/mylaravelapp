<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class announcement extends Model
{
    protected $fillable = [
        'title', 
        'content', 
        'priority',  
        'publish_date',
        'created_by'
    ];
    protected $casts = [
        'publish_date' => 'datetime',
        
    ];
    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by');
}

}
