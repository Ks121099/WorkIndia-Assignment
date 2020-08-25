<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'note'
    ];
    
    protected $hidden = [
        'created_at', 'updated_at',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
