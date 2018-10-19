<?php
namespace App\API;

class ApiPostOrder extends ApiDataBase
{
    public function __construct(SaveDataApiInterface $saveData) {
        $this->key = env('APP_API_KEY');
        $this->link = env('API_SEND_ORDER');
        $this->pricelist = env('API_PRICELIST_STORE');
        
        $this->params = [
                         'key' => $this->key,
                         'pricelist' => $this->pricelist,
                        ];
        parent::__construct($saveData);
    }

}