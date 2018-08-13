<?php
/*$new = D_Core_factory::News_News(88);

$pattern = [
    'imagesContent'   => '#<div.*?class=".*?bl-media_info--wrapper.*?>(.*?)</div>#si',
    'title' => '#<h1.*?class="news-h">(.*?)</h1>#si',
	'content' => '#<div.*?class = "bl-content--wrapper ".*?>(.*?)</div>#si',
    'content_preview' => '#<div.*?class = "bl-content--wrapper ".*?>.*?<strong>(.*?)</strong>.*?</div>#si',
];
$url = 'http://fireboxshop.com/news/summer_sneakers_top_nine.html';*/
//$docol = Core_Parser::parseByUrl($url, $new, $pattern);
//Core_Parser::parseImage( $docol['imagesContent'], $new->alias, 'slider/news' . $new->nid, 'news');

$action = D::$req->textLine('act');
$T['favorite'] = $favorite = D::$session['favorite'];
if ($action) {
    $id = D::$req->textLine('id');
    $type = D::$req->textLine('type');
    $linkText = 'товар добавлен';
    
    if($type == 'trash') {
        $linkText = '';
    }
    
    if($action == 'add') {
        if(!array_search($id, $favorite)) {
            $favorite[] = $id;
            D::$session['favorite'] = $favorite;
        }

        D::$tpl->PrintJSON([
            'success' => true,
            'type'    => $type,
            'prodId'  => $id,
            'html'    => '<a href = "#" 
                onClick = "return FireFavorite.event(' . $id . ', \'' . $type . '\', \'remove\')">
                <i class="icon_star_' . $type . '--favorite red"></i>' . $linkText . '</a>',
        ]);
    }
    if($action == 'remove') {
        $update_cab = false;
        $item = array_search($id, $favorite);
        unset($favorite[$item]);
        D::$session['favorite'] = $favorite;
        if ($type == 'cabinet') {
            $update_cab = true;
        }
        D::$tpl->PrintJSON([
            'success'    => true,
            'type'       => $type,
            'prodId'     => $id,
            'update_cab' => $update_cab,
            'html'       => '<a href = "#" 
                onClick = "return FireFavorite.event(' . $id . ', \'' . $type . '\', \'add\')">
                <i class="icon_star_' . $type . '--favorite grey"></i>' . $linkText . '</a>',
        ]);
    }
    if($action == 'update') {
        $totalFavorite = count($favorite);
        $html = '<i>
            <svg version="1.1" id="" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     width="18px" height="17.15px" viewBox="0 -1.898 18 17.15" enable-background="new 0 -1.898 18 17.15" xml:space="preserve">
                <g>
                    <path fill="#333333" d="M9.424-1.622l2.289,5.417l5.864,0.506c0.406,0.032,0.569,0.542,0.261,0.808l-4.445,3.851l1.331,5.729
                        c0.093,0.398-0.34,0.712-0.688,0.5L9,12.156l-5.036,3.035c-0.35,0.211-0.78-0.102-0.689-0.5l1.333-5.729L0.161,5.109
                        c-0.309-0.268-0.144-0.777,0.264-0.81l5.861-0.506l2.29-5.417C8.733-1.998,9.265-1.998,9.424-1.622L9.424-1.622z"/>
                </g>
                </svg>
            </i>
            <span class="cnt_favorite">' . $totalFavorite . '</span>';
            
        D::$tpl->PrintJSON([
            'success' => true,
            'type' => 'header',
            'html' => $html,
        ]);
    }
}
