<?php


namespace App\Http\Controllers;


use App\API\Service\ApiGetPriceList;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class PricesController extends Controller
{
    public function updatePrices()
    {
        Artisan::call('update-products');

        return response()->json([], 200);
    }
}