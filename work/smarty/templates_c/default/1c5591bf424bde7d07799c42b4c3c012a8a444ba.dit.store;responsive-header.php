<?php /* Smarty version Smarty3-RC3, created on 2018-07-09 14:12:33
         compiled from "dit:store;responsive-header" */ ?>
<?php /*%%SmartyHeaderCode:15926877075b4327017055f3-12280897%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c5591bf424bde7d07799c42b4c3c012a8a444ba' => 
    array (
      0 => 'dit:store;responsive-header',
      1 => 1531126801,
    ),
  ),
  'nocache_hash' => '15926877075b4327017055f3-12280897',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="bl-responsive-header">
    <button class="responsive-menu-button" target="side-mainmenu"></button>
    <div class = "bl-logo--wrapper">
        <a href="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
" class="logo"></a>
    </div>
    <div class = "bl-icon_control--wrapper">
        <div class="search-form">
            <form name="search" method="post" action="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/store/category/<?php echo $_smarty_tpl->getVariable('category')->value->code;?>
">
                <input id="search_field" type="text" name="search" value="" placeholder="Что ищем?">
                <input type="button">
                <input type="submit" value="">
            </form>
        </div>
        <div class = "bl-favorite__header--wrapper" onclick="window.location.href = '/store/favorite'; return false;">
            <i>
                <svg version="1.1" id="" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     width="18px" height="17.15px" viewBox="0 -1.898 18 17.15" enable-background="new 0 -1.898 18 17.15" xml:space="preserve">
                <g>
                    <path fill="#333333" d="M9.424-1.622l2.289,5.417l5.864,0.506c0.406,0.032,0.569,0.542,0.261,0.808l-4.445,3.851l1.331,5.729
                        c0.093,0.398-0.34,0.712-0.688,0.5L9,12.156l-5.036,3.035c-0.35,0.211-0.78-0.102-0.689-0.5l1.333-5.729L0.161,5.109
                        c-0.309-0.268-0.144-0.777,0.264-0.81l5.861-0.506l2.29-5.417C8.733-1.998,9.265-1.998,9.424-1.622L9.424-1.622z"/>
                </g>
                </svg>
            </i>
            <?php if (count(D::$session['favorite'])){?>
                <span class="cnt_favorite"><?php echo count(D::$session['favorite']);?>
</span>
            <?php }?>
        </div>
        <div class = "bl-small_trash--container">
            <div id="mcard" class="mcard_trash" onclick="window.location.href = '/store/order';">
                <?php $_template = new Smarty_Internal_Template('store;cart-widget', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
            </div>
        </div>
    </div>
</div>
<div class="responsive-menu" id="side-mainmenu">
    <button class="responsive-menu-button" target="side-mainmenu">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <div class="responsive-menu-wrapper">
                <nav class="responsive-menu-categories">
            <div class=" dropdown">
                <a href="index.html#male">Мужское</a>
                <div class="">
                    <a href="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/store/category/manfootwear">Обувь</a>
                    <a href="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/store/category/manwear">Одежда</a>
                    <a href="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/store/category/accessories">Аксессуары</a>
                    <a href="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/store/category/novelties">Новинки</a>
                    <a href="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/store/category/sales">Скидки</a>
                </div>
            </div>
            <div class=" dropdown">
                <a href="index.html#female">Женское</a>
                <div class="">
                    <a href="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/store/category/womenfootwear">Обувь</a>
                    <a href="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/store/category/womenwear">Одежда</a>
                    <a href="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/store/category/accessories">Аксессуары</a>
                    <a href="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/store/category/novelties">Новинки</a>
                    <a href="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/store/category/sales">Скидки</a>
                </div>
            </div>
            <div class=" dropdown">
                <a href="index.html#mir">Обзор товара</a>
                <div class="">
                    <a href='<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/news/video' >sportlandNEWS</a>
                    <a href='<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/news/articles' >Статьи</a>           
                </div>		
            </div>		
            <div class=" dropdown">
                <a href="index.html#about">Отзывы / Вопросы</a>            
                <div class="">
                    <a href='<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/static/reviews' >Отзывы о товаре</a>
                    <a href='<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/static/faq' >Частые вопросы</a>
                </div>		
            </div>        
        </nav>
        <div class = "bl-phone">
            <span class = 'icon tel'></span><span class = 'number_tel lptracker_phone'><?php echo D::$config['phone'];?>
</span>
        </div>
        <div class = "bl-location--wrapper">
            <div class = "bl-location_user_city--wrapper">
                <span class = "icon_location" onClick = "return Geoloc.openSelect('viewApproveLocation');"></span>
                <span class = "city" onClick = "return Geoloc.openSelect('viewApproveLocation');"></span>
                <div class = "bl-approve__location--wrapper"></div>
            </div>
        </div>
    </div>
</div>