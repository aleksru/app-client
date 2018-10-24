<?php
namespace App\API;
use Illuminate\Support\Facades\Log;

abstract class ApiDataBase 
{   
    protected $key;
    protected $link;
    protected $params = [];
    protected $saveData;
    protected $flagStop;
    
    public function __construct(SaveDataApiInterface $saveData) {
        $this->saveData = $saveData;
        $this->flagStop = false;
    }
    
    public function getDataApi()
    {
        $errors = 0;
        do{
            $c = curl_init();
            curl_setopt( $c, CURLOPT_URL, $this->getLinkParamsRender() );
            curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
            $data = curl_exec( $c );
            $status_code = curl_getinfo( $c, CURLINFO_HTTP_CODE );
            curl_close( $c );

            if ($status_code !== 200){
                if ($errors > 5) {
                    Log::error('Синхронизация прервана из за ошибки. Данные: '. $this->getLinkParamsRender(). ' HTTP STATUS: '. $status_code);
                    break;
                }
                sleep(10);
                $errors++;
                continue;
            } 
            $data = json_decode($data, true);

            if( !empty($data) ) {
                $this->saveData->saveDataApi($data);
            } 
            $this->doIteration();

            if($this->flagStop){
                break;
            }
        } while ( !empty($data) || count($data) !== 0);
    }
    
    public function sendDataApi(array $data)
    {
        $ch = curl_init();  

            curl_setopt($ch, CURLOPT_URL, $this->getLinkParamsRender());  

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
            // указываем, что у нас POST запрос  
            curl_setopt($ch, CURLOPT_POST, 1);  
            // добавляем переменные  
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            
            $status_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
            
            $output = curl_exec($ch);  

        curl_close($ch);
    }
    
    public function setKey($key)
    {
        $this->key = $key;
    }
    
    public function setLink(string $link)
    {
        $this->link = $link;
    }
    
    public function setParams($key, $params)
    {
        $this->params[$key] = $params;
    }
    
    public function getParamByKey($key)
    {
        return $this->params[$key];
    }
    
    protected function getParamsRender()
    { 
        return http_build_query($this->params);
    }
    
    protected function getLinkParamsRender()
    {
        return $this->link."?".$this->getParamsRender();
    }
    
    protected function doIteration($data=null)
    {
        /* 
         * переопределяемый метод
         * для выполнения действий в цикле 
         */
    }
    
}
