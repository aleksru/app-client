<?php
namespace App\API;
use App\Product;
use Illuminate\Support\Facades\Log;

class ProductApiSave implements SaveDataApiInterface
{
    public $data = [];
    private $interation = 0;
    public $counter = 0;
    
    public function saveDataApi($data)
    {
        if (!$this->interation) {
            $this->disableProducts();
            ++$this->interation;
        }

        foreach ($data as $value){
            $product = Product::where('sku', $value['article'])->first();
            if ( !$product ) {
                Log::error("Отсутствует товар: ".$value['article'].' '.$value['product_name']);
                continue;
            }
            $product->update(["price" => $value['price'], "status" => '1']);
            if ($product->description) {
                $product->description->update(["name" => $value['product_name']]); 
            }
            ++$this->counter;
        }
    }
    
    private function disableProducts()
    {
        Product::DisableAllProducts();
    }
    
}
