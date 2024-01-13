<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subcategory extends Model
{
    use HasFactory;
    public $timestamps = false;

    // public function category(){
    //     return $this->belongsTo(category::class,'category_id');
    // }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(category::class,'category_id','id');
    }
}
