<?php
$search = D::$req->textLine('search');
$search_cond = [];

$category_code = D::$req->textLine('param1');
$T['category'] = D_Core_Factory::Store_Category($category_code);
$categoryId = $T['category']->category_id;

if(!$search) {
    if(!D::$req->textLine('param1')) {
        D::$Tpl->redirect('/store');
    }

    $filters = [
        'brand',
        'size',
        'class',
        'season',
        'price',
        'sex',
    ];
    $cond = $filterCondition = [];

    foreach($filters as $filter) {
        if ($filter == 'price') {
            $default = ['min' => 0, 'max' => 5990];
            $priceMin = D::$req->textLine('price_from');
            $priceMax = D::$req->textLine('price_till');

            $filterCondition[$filter] = ['min' => $priceMin, 'max' => $priceMax];
            
            if($filterCondition[$filter] == $default || $priceMin == $priceMax) {
                $filterCondition[$filter] = [];
            }
        } elseif($filter == 'sex') {
            $filterValue = D::$req->textLine('param2');
            $filterCondition[$filter] = $filterValue;
        } else {
            $filterValue = D::$req->textLine($filter);
            if ($filterValue) {
                $filterCondition[$filter] = explode(',', $filterValue);
            } else {
                $filterCondition[$filter] = [];
            }
        }
    }
    if($category_code == 'novelties') {
        $categoryId = 0;
        $filterCondition['new'] = true;
    } elseif($category_code == 'sales') {
        $categoryId = 0;
        $filterCondition['discount_price'] = true;
    }
    
    $T['filterCondition'] = $filterCondition;
    
} else {
    $filterCondition = ['search' => $search];
}

$prods = Store_Product::getProductsByCategory($categoryId);
if(isset($filterCondition)) {
    $T['products'] = Store_Product::sortByFields($prods, $filterCondition);
} else {
    $T['products'] = $prods;
}

$T['fields'] = $T['category']->fields;

D::$tpl->title = $T['category']->name;
D::$tpl->description = $T['category']->descr;
if($T['category']->custom_tpl) D::$tpl->show('categories/'.$T['category']->category_code);
?>
