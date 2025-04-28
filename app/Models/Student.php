<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nis',
        'name',
        'place_birth',
        'date_birth',
        'father_name',
        'mother_name',
        'school_id',
        'class_id',
        'parent_number',
        'register_date',
        'status'
    ];

    public function class () {
        return $this->belongsTo(Option::class, 'class_id');
    }

    public function school () {
        return $this->belongsTo(Option::class, 'school_id');
    }

    public function statuses () {
        return $this->belongsTo(Option::class, 'status');
    }
}
