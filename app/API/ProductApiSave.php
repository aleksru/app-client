<?php
namespace App\API;
use App\Product;
use Carbon\Carbon;
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
            $product->special()->delete();
            if(isset($value['price_special']) && $value['price_special']){
                $product->special()->create([
                    'customer_group_id' => 1,
                    'priority' => 1,
                    'price' => $value['price_special'],
                    'date_start' => Carbon::now()->subDays(2)->toDateString(),
                    'date_end' => Carbon::now()->addYear(2)->toDateString()
                ]);
            }
            ++$this->counter;
        }
    }
    
    private function disableProducts()
    {
        Product::DisableAllProducts();
    }
    
}
