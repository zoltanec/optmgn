<?php
$cloud = new Core_I18n_Trcloud(D::$config->{'core.i18n.trcloud.key'});
$source = ['ru','en'];
echo $cloud->getTranslators('ru','it');
exit;