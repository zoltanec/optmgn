<?php
$product = D_Core_Factory::Store_Product(D::$req->int('prod_id'));
$type = D::$req->textLine('type');
$code = D::$req->textID('code');

$customField = D_Core_Factory::Store_FieldsValues($product->prod_id, $code);
if ($type == 'list') {
    $check = D::$req->textLineArray('check');
    $listValues = D::$req->textLineArray('content');
    $fieldValues = [];
    foreach($listValues as $field => $value) {
        $checked = false;
        if(in_array($field, $check)) {
            $checked = true;
        }
        $fieldValues[$field] = ['value' => $value, 'checked' => $checked];
    }
    $customField->content = serialize($fieldValues);
} else {
    $customField->content = D::$req->textLine('content');
}
$customField->save();
D::$tpl->Redirect('~/edit-product/pid_'.$product->prod_id);
//array_key_exists(34, $listValues); 
?>