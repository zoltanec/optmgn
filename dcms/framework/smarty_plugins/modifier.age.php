<?php
function smarty_modifier_age($age) {
    //конец строки
    $age = (string)$age;
    if($age[1] == "1") {
        $add = " год";
    } elseif (in_array($age[1],array("2","3","4"))) {
        $add = " года";
    } else $add = " лет";
    return $age.$add;
}
?>