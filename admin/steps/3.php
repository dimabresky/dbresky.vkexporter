<?php

if (!strlen($options->get()->access_token)):?>
    Идет получение токена доступа...
    <script>window.jsUtils.OpenWindow('<?= \dki\vkexporter\Tools::getVkAuthorizationURL($options->get()->app_id)?>', 700, 600);</script>
<?else: echo $options->get()->access_token?>
    
<?endif;?>
