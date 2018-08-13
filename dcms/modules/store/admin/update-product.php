<?php
$product=D_Core_Factory::Store_Product(D::$req->int('pid'));
D::$req->map($product, array('prod_name'=>'raw', 'bestseller'=>'int', 'psc'=>'int', 'weight'=>'int', 'producer_id'=>'int', 'category_id'=>'int', 'price'=>'int', 'mix' => 'raw', 'descr'=>'textLine', 'title' => 'textLine', 'export_code' => 'textLine', 'reciple'=>'textLine'));
$product->save();
D::$tpl->redirect(D::$req->referer());