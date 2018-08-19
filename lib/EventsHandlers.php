<?php

namespace dki\vkexporter;

/**
 * Обработчики событий
 *
 * @author ИП Бреский Дмитрий Игоревич <dimabresky@gmail.com>
 */
class EventsHandlers {
    
    public static function onAfterAddAlbum ($id) {
        
        $album = tables\Albums::getTable()->getList(["filter" => ["ID" => $id]])->fetch();
        if (isset($album["ID"])) {
            $options = new Options;
            $gateway = new Gateway($options);
            if ($album["UF_PICTURE"] > 0) {
                
                $gateway->uploadAlbumImage($album["UF_PICTURE"], $options->get()->owner_id);
            }
        }
    }
    
    public static function onAfterUpdateAlbum ($parameters) {
        
    }
}
