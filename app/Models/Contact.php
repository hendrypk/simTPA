<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    protected $fillable = 
    [
        'name',
        'whatsapp',
        'address',
        'package_id',
        'type',
        'register_date',
        'cid',
        'place_birth',
        'date_birth',
        'guardian_name',
        'guardian_number',
        'school_id',
        'class_id',
        'status_id',
        'employee_category_id'
    ];

    protected $casts = [
        'register_date' => 'datetime',
        'date_birth' => 'datetime',
    ];

    const TYPE_EMPLOYEE = 'employee';
    const TYPE_DONOR = 'donor';
    const TYPE_STUDENT = 'student';
    const TYPE_VENDOR = 'vendor';

    const TYPES = [
        self::TYPE_EMPLOYEE,
        self::TYPE_DONOR,
        self::TYPE_STUDENT,
        self::TYPE_VENDOR,
    ];

    public function classes () {
        return $this->belongsTo(Option::class, 'class_id');
    }

    public function schools () {
        return $this->belongsTo(Option::class, 'school_id');
    }

    public function statuses () {
        return $this->belongsTo(Option::class, 'status_id');
    }

    public function employee_category () {
        return $this->belongsTo(Option::class, 'employee_category_id');
    }

    public function packages () {
        return $this->belongsTo(Option::class, 'package_id');
    }
}
