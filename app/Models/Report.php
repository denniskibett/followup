<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class Report extends Model
{
    protected $fillable = ['user_id','name','date','details'];
    protected $casts = [
        'date' => 'date',
        'details' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function remarks() {
        return $this->hasMany(Remark::class);
    }
    
}
