<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function listsale()
    {
        return $this->belongsTo(listsale::class, 'listsale_id','id');
    }

    public function product()
    {
        return $this->belongsTo(products::class, 'product_id','id');
    }
}
