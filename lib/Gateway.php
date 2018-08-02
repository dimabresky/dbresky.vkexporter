<?php

namespace dki\vkexporter;

/**
 * Класс шлюз к сервису vk товары
 *
 * @author ИП Бреский Дмитрий Игоревич <dimabresky@gmail.com>
 */
class Gateway {
    
    /**
     * @var string
     */
    protected $_access_token = null;
    
    /**
     * @var string
     */
    protected $_api_url = "https://api.vk.com/method/";
    
    /**
     * @param string $access_token
     */
    public function __construct(string $access_token) {
        $this->_access_token = $access_token;
    }
    
    public function getRequestUrl (string $method, array $parameters) {
        
        return $this->_api_url . "/" . $method . "?" . http_build_query(array_merge($parameters, ["v" => 5.80]));
    }
    
    /**
     * 
     * @param int $count
     * @param int $offset
     * @return array
     * @throws \Exception
     */
    public function getCategories (int $count = 100, int $offset = 0) : array {
        
        $arCategories = [];
        
        $parameters = [
            "access_token" => $this->_access_token,
            "count" => $count,
            "offset" => $offset
        ];
        
        $response = \json_decode(\file_get_contents($this->getRequestUrl("market.getCategories", $parameters)));

        if (isset($response->response) && isset($response->response->items)) {
            
            foreach ($response->response->items as $item) {
                
                $arCategories[$item->id] = $item->name . "[" . $item->section->name . "]";
            }
        } elseif (isset($response->error)) {
            throw new \Exception($response->error->error_msg);
        }
        
        return $arCategories;
    }
}
