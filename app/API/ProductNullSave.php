<?php
namespace App\API;
use App\Product;

class ProductNullSave implements SaveDataApiInterface
{
    public $data = [];
    
    public function saveDataApi($data)
    {
       $this->data = $data;
    }
}