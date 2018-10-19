<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'oc_order';
    
    public function products()
    {
        return $this->hasMany(OcOrderProduct::class, 'order_id', 'order_id');
    }
    
}
