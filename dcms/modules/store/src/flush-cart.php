<?php
unset(D::$session['cart']);
D::$tpl->PrintJSON(['status' => 'OK']);
?>