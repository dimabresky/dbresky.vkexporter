<?php

if (!strlen($option->get()->access_token)):?>
<script>window.open("/bitrix/admin/dki_vk_access_token.php?lang=ru&action=get");</script>
<?else:?>
<?endif;?>
