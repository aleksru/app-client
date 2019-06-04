<?php


namespace App\API\Service;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ApiGetPriceList
{
    private $url = 'http://lk-skycom.shop/api/v2/store/price-list';

    public function getPriceList()
    {
        $client = new Client();
        $res = $client->get($this->generateUrl(), [
            'headers' => [
                'Authorization' => env('APP_API_KEY')
            ]
        ]);

        return json_decode($res->getBody()->getContents(), true);
    }

    /**
     * @return string
     */
    private function generateUrl()
    {
        $phone = env('API_STORE_PHONE');
        $url = env('APP_URL');
        $url = preg_replace ('/https?:\/\//', '', $url);

        return $this->url . '?' . http_build_query(['phone_number' => $phone, 'store_url' => $url]);
    }

    public function updatePriceList()
    {
        $priceList = $this->getPriceList();
        if($priceList['price-list']){
            setting(['price_list' => $priceList['price-list']]);
            setting(['price_list_system_version' => $priceList['version']]);
            setting()->save();
        }
    }
}