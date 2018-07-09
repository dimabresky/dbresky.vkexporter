<?php

return array(
    "table" => "dky_vkexporter",
    "table_data" => array(
        "NAME" => "DKYVKEXPORTER",
        "ERR" => "Ошибка при создании highloadblock'a dky_vkexporter",
        "LANGS" => array(
            "ru" => 'Таблица экспортированных данных',
            "en" => "Vkexporter"
        ),
        "OPTION_PARAMETER" => "VKEXPORTER_STORAGE_ID"
    ),
    "fields" => array(
        array(
            "ENTITY_ID" => 'HLBLOCK_{{table_id}}',
            "FIELD_NAME" => "UF_IBLOCK_ID",
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
                'ru' => 'ID инфоблока',
                'en' => 'Iblock id',
            ),
            'LIST_COLUMN_LABEL' => array(
                'ru' => 'ID инфоблока',
                'en' => 'Iblock id',
            ),
            'LIST_FILTER_LABEL' => array(
                'ru' => 'ID инфоблока',
                'en' => 'Iblock id',
            ),
            'ERROR_MESSAGE' => array(
                'ru' => 'Ошибка при заполнении поля "ID инфоблока" ',
                'en' => 'An error in completing the field "Iblock id"',
            ),
            'HELP_MESSAGE' => array(
                'ru' => '',
                'en' => '',
            ),
        ),
        array(
            "ENTITY_ID" => 'HLBLOCK_{{table_id}}',
            "FIELD_NAME" => "UF_BX_ID",
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
                'ru' => 'ID элемента инфоблока',
                'en' => 'BX element id',
            ),
            'LIST_COLUMN_LABEL' => array(
                'ru' => 'ID элемента инфоблока',
                'en' => 'BX element id',
            ),
            'LIST_FILTER_LABEL' => array(
                'ru' => 'ID элемента инфоблока',
                'en' => 'BX element id',
            ),
            'ERROR_MESSAGE' => array(
                'ru' => 'Ошибка при заполнении поля "ID элемента инфоблока" ',
                'en' => 'An error in completing the field "BX element id"',
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
                'ru' => 'ID элемента в vk',
                'en' => 'VK element id',
            ),
            'LIST_COLUMN_LABEL' => array(
                'ru' => 'ID элемента в vk',
                'en' => 'VK element id',
            ),
            'LIST_FILTER_LABEL' => array(
                'ru' => 'ID элемента в vk',
                'en' => 'VK element id',
            ),
            'ERROR_MESSAGE' => array(
                'ru' => 'Ошибка при заполнении поля "ID элемента в vk" ',
                'en' => 'An error in completing the field "VK element id"',
            ),
            'HELP_MESSAGE' => array(
                'ru' => '',
                'en' => '',
            ),
        ),
        array(
                "ENTITY_ID" => 'HLBLOCK_{{table_id}}',
            "FIELD_NAME" => "UF_BX_IMAGE_ID",
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
                'ru' => 'ID изображения',
                'en' => 'Image id',
            ),
            'LIST_COLUMN_LABEL' => array(
                'ru' => 'ID изображения',
                'en' => 'Image id',
            ),
            'LIST_FILTER_LABEL' => array(
                'ru' => 'ID изображения',
                'en' => 'Image id',
            ),
            'ERROR_MESSAGE' => array(
                'ru' => 'Ошибка при заполнении поля "ID изображения" ',
                'en' => 'An error in completing the field "Image id"',
            ),
            'HELP_MESSAGE' => array(
                'ru' => '',
                'en' => '',
            ),
        ),
        array(
                "ENTITY_ID" => 'HLBLOCK_{{table_id}}',
            "FIELD_NAME" => "UF_VK_IMAGE_ID",
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
                'ru' => 'ID изображения в vk',
                'en' => 'Image vk id',
            ),
            'LIST_COLUMN_LABEL' => array(
                'ru' => 'ID изображения в vk',
                'en' => 'Image vk id',
            ),
            'LIST_FILTER_LABEL' => array(
                'ru' => 'ID изображения в vk',
                'en' => 'Image vk id',
            ),
            'ERROR_MESSAGE' => array(
                'ru' => 'Ошибка при заполнении поля "ID изображения в vk" ',
                'en' => 'An error in completing the field "Image vk id"',
            ),
            'HELP_MESSAGE' => array(
                'ru' => '',
                'en' => '',
            ),
        )
    )
);
