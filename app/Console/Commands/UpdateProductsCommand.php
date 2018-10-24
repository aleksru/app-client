<?php

namespace App\Console\Commands;

use App\API\ProductApiSave;
use App\API\ProductNullSave;
use App\Product;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UpdateProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-products';

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
    public function handle(ProductNullSave $productNullSave, ProductApiSave $productApiSave)
    {
        (new \App\API\ApiGetPriceListVersion($productNullSave))->getDataApi();
        Log::error("Начало синхронизации. Текущая версия прайс-листа: ".Cache::get('price_version')." Актуальная:".$productNullSave->data[env('API_PRICELIST_STORE')]);

        if(Cache::get('price_version') != $productNullSave->data[env('API_PRICELIST_STORE')]){
            (new \App\API\ApiGetProduct($productApiSave))->getDataApi();
            Product::enableDefaultProducts();
        }
        Log::error("Обновление товаров завершено. Обновлено: ". ($productApiSave->counter ?? '0')." товара.");
        Cache::put('price_version', $productNullSave->data[env('API_PRICELIST_STORE')], Carbon::now()->addDay());

    }
}
