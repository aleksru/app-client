<?php
namespace App\API;

class ApiGetProduct extends ApiDataBase
{
    public function __construct(SaveDataApiInterface $saveData) {
        $this->key = env('APP_API_KEY');
        $this->link = env('API_GET_PRODUCT_LINK');
        $this->pricelist = env('API_PRICELIST_STORE');
        $this->params = [
                         'key' => $this->key,
                         'pricelist' => $this->pricelist,
                         'count' => 50,
                         "page" => 0
                        ];
        parent::__construct($saveData);
    }
    
    protected function doIteration( $data = null )
    {
        $page = $this->getParamByKey('page');
        $page = ++$page;
        $this->setParams('page', $page);
    }
}
