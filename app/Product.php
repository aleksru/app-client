<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $table = 'oc_product';
    
    protected $guarded = ['product_id'];
    
    protected $primaryKey = 'product_id';
    
    public $timestamps = false;
    
    static public function DisableAllProducts()
    {
        DB::table('oc_product')->whereNotNull('sku')->update(['status' => '0']); 
    }
    
    public function description()
    {
        return $this->hasOne(ProductDescription::class, 'product_id', 'product_id');
    }

    /**
     * Включение товаров по умолчанию
     */
    public static function enableDefaultProducts()
    {
        if(empty(config('app.default_enable_products'))){
            return false;
        }

        Product::whereIn('product_id', config('app.default_enable_products'))->update(['status' => 1]);
    }
}
