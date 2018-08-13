<?php
//модификатор
function smarty_modifier_random($end) {
    return rand(1,intval($end));
}
?>