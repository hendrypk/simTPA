<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'whatsapp',
        'address',
        'register_date',
        'package_id',
        'status_id'
    ];

    public function package () {
        return $this->belongsTo(Option::class, 'package_id');
    }

    public function status () {
        return $this->belongsTo(Option::class, 'status_id');
    }
}
