<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{
    protected $table = 'oc_product_description';
    
    protected $guarded = ['product_id'];
    
    protected $primaryKey = 'product_id';
    
    public $timestamps = false;
}
