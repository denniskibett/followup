<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    protected $fillable = ['report_id','ps_id','remark'];

    public function report() {
        return $this->belongsTo(Report::class);
    }

    public function ps() {
        return $this->belongsTo(User::class, 'ps_id');
    }
}
