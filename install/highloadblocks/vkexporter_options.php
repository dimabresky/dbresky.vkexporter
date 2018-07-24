<?php

return array(
    "table" => "dki_vkexporter_options",
    "table_data" => array(
        "NAME" => "DKIVKEXPORTEROPTIONS",
        "ERR" => "Ошибка при создании highloadblock'a dki_vkexporter_options",
        "LANGS" => array(
            "ru" => 'Таблица настроек экспорта данных',
            "en" => "Vkexporter options"
        ),
        "OPTION_PARAMETER" => "VKEXPORTER_OPTIONS_STORAGE_ID"
    ),
    "fields" => array(
        array(
            "ENTITY_ID" => 'HLBLOCK_{{table_id}}',
            "FIELD_NAME" => "UF_USER_ID",
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
                'ru' => 'ID пользователя',
                'en' => 'User id',
            ),
            'LIST_COLUMN_LABEL' => array(
                'ru' => 'ID пользователя',
                'en' => 'User id',
            ),
            'LIST_FILTER_LABEL' => array(
                'ru' => 'ID пользователя',
                'en' => 'User id',
            ),
            'ERROR_MESSAGE' => array(
                'ru' => 'Ошибка при заполнении поля "ID пользователя" ',
                'en' => 'An error in completing the field "User id"',
            ),
            'HELP_MESSAGE' => array(
                'ru' => '',
                'en' => '',
            ),
        ),
        array(
            "ENTITY_ID" => 'HLBLOCK_{{table_id}}',
            "FIELD_NAME" => "UF_OPTIONS",
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
                'ru' => 'Настройки',
                'en' => 'Options',
            ),
            'LIST_COLUMN_LABEL' => array(
                'ru' => 'Настройки',
                'en' => 'Options',
            ),
            'LIST_FILTER_LABEL' => array(
                'ru' => 'Настройки',
                'en' => 'Options',
            ),
            'ERROR_MESSAGE' => array(
                'ru' => 'Ошибка при заполнении поля "Настройки" ',
                'en' => 'An error in completing the field "Options"',
            ),
            'HELP_MESSAGE' => array(
                'ru' => '',
                'en' => '',
            ),
        )
    )
);
