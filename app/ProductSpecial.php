<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSpecial extends Model
{
    protected $guarded = ['product_special_id'];
    protected $table = 'oc_product_special';
    public $timestamps = false;
}
