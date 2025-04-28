<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'whatsapp',
        'register_date',
        'status',
        'category_id'
    ];

    public function statuses () {
        return $this->belongsTo(Option::class, 'status');
    }

    public function category () {
        return $this->belongsTo(Option::class, 'category_id');
    }
}
