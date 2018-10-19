<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OcOrderProduct extends Model
{
    protected $table = 'oc_order_product';
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
