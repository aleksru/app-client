<?php

namespace App\Console\Commands;

use App\API\ProductApiSave;
use App\API\ProductNullSave;
use App\API\Service\ApiGetPriceList;
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
    public function handle(ProductApiSave $productApiSave)
    {
        (new ApiGetPriceList())->updatePriceList();
        $priceList = setting('price_list');
        $priceListVer = setting('price_version');
        $priceListSys = setting('price_list_system_version');
        Log::error("Запрос на обновление цен. Прайс: {$priceList}, Version: $priceListVer");
        if($priceList && $priceListVer !== $priceListSys){
            Log::error("Начало синхронизации. Текущая версия прайс-листа: ". $priceListVer." Актуальная:" . $priceListSys);
            (new \App\API\ApiGetProduct($productApiSave))->getDataApi();
            Product::enableDefaultProducts();
            setting(['price_version' => $priceListSys]);
            setting()->save();
            Log::error("Обновление товаров завершено. Обновлено: ". ($productApiSave->counter)." товара.");
        }
    }
}
