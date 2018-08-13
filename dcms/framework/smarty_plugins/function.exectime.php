<?php
//вычисление времени работы шаблона
function smarty_function_exectime($params,&$smarty) {
    return round((microtime(TRUE) - D::$starttime) * 1000,2);
}
?>