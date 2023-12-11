<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    protected $guarded = [];  

    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(subcategory::class, 'sub_category_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'product_id','id');
    }
    public function features()
    {
        return $this->hasMany(Feature::class, 'product_id','id');
    }
}
