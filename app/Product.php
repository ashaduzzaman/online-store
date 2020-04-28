<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name', 'category_id', 'price', 'units', 'description', 'image'
    ];
    
    public function orders(){
        return $this->hasMany(Order::class);
    }
}