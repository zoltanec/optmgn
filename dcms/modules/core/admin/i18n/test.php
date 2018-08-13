<?php
echo "<pre>";
header("Content-type: text/html; charset=UTF-8");
var_dump(Core_I18n_MyMemory::getTranslation('Privacy policy', 'en', 'ko'));
echo "OK";
exit;