<?php
/**
 * Created by PhpStorm.
 * User: ryjkov.adm
 * Date: 24.10.2018
 * Time: 19:39
 */

namespace App\API;


class ApiGetPriceListVersion extends ApiDataBase
{
    public function __construct(SaveDataApiInterface $saveData) {
        $this->key = env('APP_API_KEY');
        $this->link = env('API_GET_ROOT').'/api/price-version';
        $this->pricelist = env('API_PRICELIST_STORE');
        $this->params = [
            'key' => $this->key,
            'pricelist' => $this->pricelist,
            'count' => 50,
            "page" => 0
        ];
        parent::__construct($saveData);
    }

    protected function doIteration($data=null)
    {
        $this->flagStop = true;
    }

}