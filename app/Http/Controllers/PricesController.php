<?php


namespace App\Http\Controllers;


use App\API\Service\ApiGetPriceList;
use Illuminate\Support\Facades\Log;

class PricesController extends Controller
{
    public function updatePrices()
    {
        setting(['is_update_prices' => 1])->save();
        setting(['price_version' => 1])->save();

        return response()->json([], 200);
    }
}