<?php

class Api
{
    protected $apiKey;
    protected $storeKey;

    public const API2CART_API_URL = 'http://api.api2cart.com/v1.0/';

    public function __construct($apiKey = null, $storeKey = null)
    {
        $this->setApiKey($apiKey);
        $this->setStoreKey($storeKey);

    }

    private function setApiKey($apiKey){
        $this->apiKey = $apiKey;
    }

    private function getApiKey(){
        return $this->apiKey;
    }

    private function setStoreKey($storeKey){
        $this->storeKey = $storeKey;
    }

    private function getStoreKey(){
        return $this->storeKey;
    }

    public function request(string $entity, string $typeRequest, array $parametr = [])
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.api2cart.com/v1.0/' . $entity . '?api_key=' . $this->getApiKey() . '&store_key=' . $this->getStoreKey() . $this->getParametr($parametr),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response,true);
    }


    public function getParametr(array $parametr = []) : string
    {
        $result = '';
        if ($parametr !== []) {
            foreach ($parametr as $key => $value) {
                $result = $result . '&' . $key .'=' . $value;
            }
        }
        return $result;
    }

    public function getAllProducts() : array
    {
        $products = [];
        $step = 10;
        $start = 0;

        do {
            $response = $this->request('product.list.json','GET',['count' => $step, 'start' => $start]);
            if (!empty($response['result']['product'])) {
                foreach ($response['result']['product'] as $value){
                    $records [] = $value;
                }
            }
            $start += $step;

        } while (!empty($response['result']['products_count']));

        return $records;
    }

    public function getInfoOneProduct(string $id, array $fields) : array
    {
        $response = $this->request('product.info.json','GET',['id' => $id, 'params' => implode(",", $fields)]);
        return $response['result'];

    }
}