<?php

namespace App\Console\Commands;

use App\Product;
use Illuminate\Console\Command;
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
    public function handle()
    {
        $data = new \App\API\ProductApiSave();
        (new \App\API\ApiGetProduct($data))->getDataApi();
        Product::enableDefaultProducts();
        Log::error("Обновление товаров завершено. Обновлено: ".$data->counter." товара.");
    }
}
