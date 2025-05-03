<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'transaction_id',
        'payable_id',
        'wallet_id',
        'type',
        'related_id',
        'related_model',
        'transaction_at',
        'amount',
        'meta',
        'is_donor'
    ];

    protected $casts = [
        'wallet_id' => 'int',
        'payable_id' => 'int',
        'transaction_at' => 'datetime',
    ];
    
    const TYPE_CREDIT   = 'credit';
    const TYPE_DEBET    = 'debet';
    const TYPE_TRANSFER = 'transfer';
    const TYPE_DONOR    = 'donor';

    public static function dbid(){
        $prefix = 'DB' . now()->format('ym');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
    
        return $prefix . $random;
    }

    public static function crid(){
        $prefix = 'CR' . now()->format('ym');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
    
        return $prefix . $random;
    }

    public static function tfid(){
        $prefix = 'TF' . now()->format('ym');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
    
        return $prefix . $random;
    }

    public static function dnid(){
        $prefix = 'DN' . now()->format('ym');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
    
        return $prefix . $random;
    }
     
    public function payable () {
        return $this->belongsTo(Option::class, 'payable_id');
    }

    public function wallet () {
        return $this->belongsTo(Option::class, 'wallet_id');
    }

    public function employee () {
        return $this->belongsTo(Employee::class, 'related_id');
    }

    public function contact_name () {
        return $this->belongsTo(Contact::class, 'related_id');
    }


}
