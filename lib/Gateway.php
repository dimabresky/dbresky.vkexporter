<?php

namespace dki\vkexporter;

/**
 * Класс шлюз к сервису vk товары
 *
 * @author ИП Бреский Дмитрий Игоревич <dimabresky@gmail.com>
 */
class Gateway {

    /**
     * @var dki\vkexporter\Options
     */
    protected $_options = null;

    /**
     * @var Bitrix\Main\Request
     */
    protected $_request = null;

    /**
     * @var string
     */
    protected $_api_url = "https://api.vk.com/method/";

    /**
     * @var string 
     */
    protected $_auth_url = "https://oauth.vk.com/authorize/";

    /**
     * @var string 
     */
    protected $_access_token_url = "https://oauth.vk.com/access_token";

    /**
     * @param string $access_token
     * @param int $app_id
     */
    public function __construct(\dki\vkexporter\Options $options) {
        $this->_options = $options;
        $this->_request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
    }

    public function getRequestUrl(string $method, array $parameters) {
        return $this->_api_url . "/" . $method . "?" . http_build_query(array_merge($parameters, ["v" => 5.80]));
    }

    /**
     * @return string
     */
    public function getVkAuthorizationUrl() {

        $arParams = array(
            'client_id' => $this->_options->get()->app_id,
            'redirect_uri' => ($this->_request->isHttps() ? 'https://' : 'http://') . $this->_request->getHttpHost() . "/bitrix/admin/dki_vk_access_token.php",
            'display' => 'popup',
            'scope' => implode(',', array('notifications', 'market', 'offline', 'stats', 'user', 'groups', 'photos')),
            'response_type' => 'token',
            'revoke' => 1,
            'v' => 5.80,
            'state' => ''
        );


        return $this->_auth_url . '?' . http_build_query($arParams);
    }

    /**
     * @return boolean
     */
    public function getAccessToken() {

        if ($this->_request->get("redirected") !== "yes") {
            ?><script>window.location.href = "?" + window.location.hash.replace("#", "") + "&redirected=yes";</script><?
            exit;
        } elseif (strlen($this->_request->get("access_token")) > 0) {
            $this->_options->save(array("access_token" => $this->_request->get("access_token")));
            ?><script>window.opener.location.reload();window.close();</script><?
            exit;
        }

        return false;
    }

    /**
     * 
     * @param int $count
     * @param int $offset
     * @return array
     * @throws \Exception
     */
    public function getCategories(int $count = 100, int $offset = 0) {

        $arCategories = [];

        $parameters = [
            "access_token" => $this->_options->get()->access_token,
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

    /**
     * @param int $bx_file_id
     * @return \stdClass
     */
    public function uploadAlbumImage(int $bx_file_id) {

        // get upload url
        $result = \json_decode(\file_get_contents($this->getRequestUrl("photos.getMarketAlbumUploadServer", [
                            "group_id" => $this->_options->get()->owner_id,
                            "access_token" => $this->_options->get()->access_token,
        ])));

        if (strlen($result->response->upload_url)) {

            $arFile = \CFile::GetFileArray($bx_file_id);
            if (@$arFile["ID"] > 0) {
                $file_path = \Bitrix\Main\Application::getDocumentRoot() . $arFile["SRC"];
                $boundary = "--" . time();
                $header = 'Content-Type: multipart/form-data; boundary=' . $boundary;
                $content = \file_get_contents($file_path);
                $body = "--" . $boundary . "\r\n"
                        . "Content-Disposition: form-data; name=\"file\"; filename=\"" . basename($file_path) . "\"\r\n"
                        . "Content-Type: " . $arFile["CONTENT_TYPE"] . "\r\n\r\n"
                        . $content . "\r\n"
                        . "--" . $boundary . "--\r\n";
                $upload_file_result = \json_decode(\file_get_contents($result->response->upload_url, false, \stream_context_create([
                    "http" => [
                        "method" => "POST",
                        "header" => $header,
                        "content" => $content
                    ]
                ])));

                if (strlen($upload_file_result->photo)) {
                    $result = \json_decode(\file_get_contents($this->getRequestUrl("photos.saveMarketAlbumPhoto", [
                                        "group_id" => $this->_options->get()->owner_id,
                                        "access_token" => $this->_options->get()->access_token,
                                        "photo" => $upload_file_result->photo,
                                        "server" => $upload_file_result->server,
                                        "hash" => $upload_file_result->hash
                    ])));
                    dm($result);die;
                }
            }
        }

        return new \stdClass();
    }

}
