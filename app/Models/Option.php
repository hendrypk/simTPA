<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'amount',
        'wallet_type'
    ];

    // Constant untuk nilai 'type'
    public const TYPE_CREDIT  = 'credit';
    public const TYPE_DEBIT   = 'debet';
    public const TYPE_CLASS   = 'class';
    public const TYPE_SCHOOL  = 'school';
    public const TYPE_PACKAGE = 'package';
    public const TYPE_WALLET = 'wallet';
    public const TYPE_STUDENT_STATUS = 'student status';
    public const TYPE_DONATUR_STATUS = 'donatur status';
    public const TYPE_EMPLOYEE_STATUS = 'employee status';
    public const TYPE_EMPLOYEE_CATEGORY = 'employee category';


    // (Optional) Array untuk digunakan di form dropdown, dsb
    public const TYPES = [
        self::TYPE_CREDIT  => 'credit',
        self::TYPE_DEBIT   => 'debet',
        self::TYPE_CLASS   => 'class',
        self::TYPE_SCHOOL  => 'school',
        self::TYPE_PACKAGE => 'package',
        self::TYPE_WALLET => 'wallet',
        self::TYPE_STUDENT_STATUS => 'student status',
        self::TYPE_DONATUR_STATUS => 'donatur status',
        self::TYPE_EMPLOYEE_STATUS => 'employee status',
        self::TYPE_EMPLOYEE_CATEGORY => 'employee category',
    ];
}
