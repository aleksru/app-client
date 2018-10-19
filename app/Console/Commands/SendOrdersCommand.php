<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\SendOrder;
use App\Order;

class SendOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $maxSendOrder = SendOrder::max('order_id');
        if (!$maxSendOrder){
            $maxSendOrder = 0;
        }  
        $getOrders = Order::where('order_id', '>', $maxSendOrder)->with('products', 'products.product')->get();
        if (!$getOrders->isEmpty()){
            foreach ($getOrders as $getOrder) {
                $order = [
                    'name_customer' => !empty($getOrder->firstname) ? $getOrder->firstname : 'No name',
                    'store' =>env('APP_URL'),
                    'phone' => !empty($getOrder->telephone) ? $getOrder->telephone : 'No phone',
                    'total' => !empty($getOrder->total) ? $getOrder->total : 'No total',
                    'comment' => !empty($getOrder->comment) ? $getOrder->comment : 'No comment',
                    'products' => json_encode([['articul' =>'none', 'name'=>'none', 'price'=>'none']], JSON_UNESCAPED_SLASHES), 
                ];

                if (!$getOrder->products->isEmpty()){
                    $products = [];
                    foreach ($getOrder->products as $product) {
                        $products[] = ['articul' => $product->product->sku,
                                        'quantity' => $product->quantity,
                                        'name' => $product->name, 
                                        'price' => (integer)$product->product->price
                                    ];
                    }
                    $order['products'] = json_encode($products, JSON_UNESCAPED_SLASHES);
                }
                $data = new \App\API\ProductNullSave();
                (new \App\API\ApiPostOrder($data))->sendDataApi($order);
                SendOrder::create(['order_id' => $getOrder->order_id]);
                Log::error("Заказ отправлен в лк. ИД: ".$getOrder->order_id);
                
            }
        }
        
    }
}
