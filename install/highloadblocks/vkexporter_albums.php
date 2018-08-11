<?php

return array(
    "table" => "dki_vkexporter_albums",
    "table_data" => array(
        "NAME" => "DKIVKEXPORTERALBUMS",
        "ERR" => "Ошибка при создании highloadblock'a dki_vkexporter_albums",
        "LANGS" => array(
            "ru" => 'Таблица подборок',
            "en" => "Vkexporter albums"
        ),
        "OPTION_PARAMETER" => "VKEXPORTER_ALBUMS_STORAGE_ID"
    ),
    "fields" => array(
        array(
            "ENTITY_ID" => 'HLBLOCK_{{table_id}}',
            "FIELD_NAME" => "UF_NAME",
            "USER_TYPE_ID" => 'string',
            "XML_ID" => "",
            "SORT" => 100,
            "MULTIPLE" => 'N',
            'MANDATORY' => 'N',
            'SHOW_FILTER' => 'N',
            'SHOW_IN_LIST' => 'Y',
            'IS_SEARCHABLE' => 'N',
            'SETTINGS' => array(
                'DEFAULT_VALUE' => "",
                'SIZE' => '20',
                'ROWS' => 1,
                'MIN_LENGTH' => 0,
                'MAX_LENGTH' => 0,
                'REGEXP' => ''
            ),
            'EDIT_FORM_LABEL' => array(
                'ru' => 'Название',
                'en' => 'Name',
            ),
            'LIST_COLUMN_LABEL' => array(
                'ru' => 'Название',
                'en' => 'Name',
            ),
            'LIST_FILTER_LABEL' => array(
                'ru' => 'Название',
                'en' => 'Name',
            ),
            'ERROR_MESSAGE' => array(
                'ru' => 'Ошибка при заполнении поля "Название" ',
                'en' => 'An error in completing the field "Name"',
            ),
            'HELP_MESSAGE' => array(
                'ru' => '',
                'en' => '',
            ),
        ),
        array(
            "ENTITY_ID" => 'HLBLOCK_{{table_id}}',
            "FIELD_NAME" => "UF_PICTURE",
            "USER_TYPE_ID" => 'file',
            "XML_ID" => "",
            "SORT" => 100,
            "MULTIPLE" => 'N',
            'MANDATORY' => 'N',
            'SHOW_FILTER' => 'N',
            'SHOW_IN_LIST' => 'Y',
            'IS_SEARCHABLE' => 'N',
            'SETTINGS' => array(
                'DEFAULT_VALUE' => "",
                'SIZE' => '20',
                'ROWS' => 1,
                'MIN_LENGTH' => 0,
                'MAX_LENGTH' => 0,
                'REGEXP' => ''
            ),
            'EDIT_FORM_LABEL' => array(
                'ru' => 'Фото',
                'en' => 'Photo',
            ),
            'LIST_COLUMN_LABEL' => array(
                'ru' => 'Фото',
                'en' => 'Photo',
            ),
            'LIST_FILTER_LABEL' => array(
                'ru' => 'Фото',
                'en' => 'Photo',
            ),
            'ERROR_MESSAGE' => array(
                'ru' => 'Ошибка при заполнении поля "Фото" ',
                'en' => 'An error in completing the field "Photo"',
            ),
            'HELP_MESSAGE' => array(
                'ru' => '',
                'en' => '',
            ),
        ),
        array(
            "ENTITY_ID" => 'HLBLOCK_{{table_id}}',
            "FIELD_NAME" => "UF_VK_ID",
            "USER_TYPE_ID" => 'integer',
            "XML_ID" => "",
            "SORT" => 100,
            "MULTIPLE" => 'N',
            'MANDATORY' => 'N',
            'SHOW_FILTER' => 'N',
            'SHOW_IN_LIST' => 'Y',
            'IS_SEARCHABLE' => 'N',
            'SETTINGS' => array(
                'DEFAULT_VALUE' => "",
                'SIZE' => '20',
                'ROWS' => 1,
                'MIN_LENGTH' => 0,
                'MAX_LENGTH' => 0,
                'REGEXP' => ''
            ),
            'EDIT_FORM_LABEL' => array(
                'ru' => 'ID подборки в vk',
                'en' => 'Album vk id',
            ),
            'LIST_COLUMN_LABEL' => array(
                'ru' => 'ID подборки в vk',
                'en' => 'Album vk id',
            ),
            'LIST_FILTER_LABEL' => array(
                'ru' => 'ID подборки в vk',
                'en' => 'Album vk id',
            ),
            'ERROR_MESSAGE' => array(
                'ru' => 'Ошибка при заполнении поля "ID подборки в vk" ',
                'en' => 'An error in completing the field "Album vk id"',
            ),
            'HELP_MESSAGE' => array(
                'ru' => '',
                'en' => '',
            ),
        )
    )
);
