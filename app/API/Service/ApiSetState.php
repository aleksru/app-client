<?php


namespace App\API\Service;



use GuzzleHttp\Client;

class ApiSetState
{
    private $url = 'https://lk-skycom.shop/api/v2/store/set-online';

    public function send()
    {
        $client = new Client();
        $res = $client->post($this->url, [
            'headers' => [
                'Authorization' => env('APP_API_KEY')
            ],
            'form_params' => $this->generateBody()
        ]);

        return json_decode($res->getBody()->getContents(), true);
    }

    /**
     * @return array
     */
    private function generateBody()
    {
        $phone = env('API_STORE_PHONE');
        $url = env('APP_URL');

        return ['phone_number' => $phone, 'store_url' => $url];
    }
}