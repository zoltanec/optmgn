<?php
function smarty_function_linklab($params, $smarty) {
    include_once(D::$Path.'/linklab.php');
    $LinkLab = new LinkLab_client();
    $link_html = $LinkLab->getCode();
   // return $_SERVER['DOCUMENT_ROOT'];
    return $link_html;
}
?>