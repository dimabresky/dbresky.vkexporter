<?php

namespace dbresky\vkexporter;

/**
 * Обработчики событий
 *
 * @author ИП Бреский Дмитрий Игоревич <dimabresky@gmail.com>
 */
class EventsHandlers {

    public static function onAfterAddAlbum($id) {

        $album = tables\Albums::getTable()->getList(["filter" => ["ID" => $id]])->fetch();
        if (isset($album["ID"])) {
            $options = new Options;
            $gateway = new Gateway($options);
            $upload_image_result = new \stdClass();
            if ($album["UF_PICTURE"] > 0) {

                $upload_image_result = $gateway->uploadAlbumImage($album["UF_PICTURE"]);
            }

            dm($upload_image_result);
            die;
        }
    }

    public static function onAfterUpdateAlbum($parameters) {
        
    }

}
