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

    // (Optional) Array untuk digunakan di form dropdown, dsb
    public const TYPES = [
        self::TYPE_CREDIT  => 'credit',
        self::TYPE_DEBIT   => 'debet',
        self::TYPE_CLASS   => 'class',
        self::TYPE_SCHOOL  => 'school',
        self::TYPE_PACKAGE => 'package',
        self::TYPE_WALLET => 'wallet',
    ];
}
