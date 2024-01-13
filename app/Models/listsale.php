<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class listsale extends Model
{
    use HasFactory;
    // protected $primaryKey = 'order_code';
    protected $fillable = [
        'product_id',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class,'listsale_id','id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    protected static function boot()
    {
        parent::boot();

        self::creating(function ($order) {
            $existingOrderCodes = listsale::pluck('order_code')->toArray();

            do {
                $randomNumber = rand(10000, 99999);
                $orderCode = '#' . date('ymd') . $randomNumber;
            } while (in_array($orderCode, $existingOrderCodes));

            $order->order_code = $orderCode;
        });
    }
}
