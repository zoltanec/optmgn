<?php /* Smarty version Smarty3-RC3, created on 2018-07-09 18:03:38
         compiled from "dit:store;show-product" */ ?>
<?php /*%%SmartyHeaderCode:14671825205b435d2acb5448-95680742%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e17a814b925bca02dc10d58783c3edd6b0d1bd1a' => 
    array (
      0 => 'dit:store;show-product',
      1 => 1531126801,
    ),
  ),
  'nocache_hash' => '14671825205b435d2acb5448-95680742',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="content" class="clearfix">
    <link href="<?php echo $_smarty_tpl->getVariable('theme')->value['css'];?>
/catalog/trash.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $_smarty_tpl->getVariable('theme')->value['css'];?>
/catalog/order.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $_smarty_tpl->getVariable('theme')->value['css'];?>
/catalog/catalog.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $_smarty_tpl->getVariable('config')->value->jscripts_path;?>
/theme/jquery.mCustomScrollbar.min.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value->jscripts_path;?>
/theme/scrolltotop.js"></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value->jscripts_path;?>
/theme/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value->jscripts_path;?>
/theme/catalog/order.js"></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value->jscripts_path;?>
/theme/catalog/catalog.js"></script>
    <div class="content w1024">
        <div class="item-info">
            <?php if ($_smarty_tpl->getVariable('prod')->value->fields['new']->content){?>
                <div class="shild-left novinka_cart"></div>
            <?php }?>
            <?php if ($_smarty_tpl->getVariable('prod')->value->fields['club']->content){?>
                <div class="shild-left club_cart" onclick="return Good.scrollToClub();"></div>
            <?php }?>
            <?php if ($_smarty_tpl->getVariable('prod')->value->fields['sale']->content){?>
                <div class="shild-left skidka_ico_cart sale990"></div>
            <?php }?>
            <div class="item-photo owl-carousel owl-theme owl-center owl-loaded" style="visibility: hidden;">
                <?php  $_smarty_tpl->tpl_vars['picture'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('prod')->value->pictures; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['picture']->key => $_smarty_tpl->tpl_vars['picture']->value){
?>
                                            <a id="big-photo" class="fancy_ex" rel="good" href="<?php echo $_smarty_tpl->getVariable('me')->value['content'];?>
/media/product<?php echo $_smarty_tpl->getVariable('prod')->value->prod_id;?>
/<?php echo $_smarty_tpl->getVariable('picture')->value->fileid;?>
">
                            <img src="<?php echo $_smarty_tpl->getVariable('me')->value['content'];?>
/media/thumbs/product<?php echo $_smarty_tpl->getVariable('prod')->value->prod_id;?>
/<?php echo $_smarty_tpl->getVariable('picture')->value->fileid;?>
" alt="<?php echo $_smarty_tpl->getVariable('prod')->value->prod_name;?>
">
                        </a>
                <?php }} ?>
            </div>
            <div class="clear"></div>
            <div class="bl-good_cart--center">
                <div class="bl-control--card">
                    <div class="bl-info_good--header">
                        <div class="info">
                            <h1 class="maker"><?php echo $_smarty_tpl->getVariable('prod')->value->prod_name;?>
</h1>
                        </div>
                    </div>
                    <div class="bl-table_size">
                    
                        <?php if ($_smarty_tpl->getVariable('prod')->value->category_code=='womenwear'){?>
                            <?php $_smarty_tpl->tpl_vars['sizeTable'] = new Smarty_variable('wear-women-sizes', null, null);?>
                        <?php }elseif($_smarty_tpl->getVariable('prod')->value->category_code=='manwear'){?>
                            <?php $_smarty_tpl->tpl_vars['sizeTable'] = new Smarty_variable('wear-men-sizes', null, null);?>
                        <?php }elseif($_smarty_tpl->getVariable('prod')->value->category_code=='manfootwear'){?>
                            <?php $_smarty_tpl->tpl_vars['sizeTable'] = new Smarty_variable('footwear-men-sizes', null, null);?>
                        <?php }elseif($_smarty_tpl->getVariable('prod')->value->category_code=='womenfootwear'){?>
                            <?php $_smarty_tpl->tpl_vars['sizeTable'] = new Smarty_variable('footwear-women-sizes', null, null);?>
                        <?php }elseif($_smarty_tpl->getVariable('prod')->value->fields['unisex']->content){?>
                            <?php $_smarty_tpl->tpl_vars['sizeTable'] = new Smarty_variable('wear-unisex-sizes', null, null);?>
                        <?php }?>
                        <?php if ($_smarty_tpl->getVariable('sizeTable')->value){?>
                            <a href="javascript: ins_ajax_open('/static/<?php echo $_smarty_tpl->getVariable('sizeTable')->value;?>
', 0, 0, 0); void(0);" class="size-link">Таблица размеров</a>
                        <?php }?>
                    </div>
                    <div class="bl-info_cost--header">
                        <div class="cost">
                            <div>
                                <?php if (!$_smarty_tpl->getVariable('prod')->value->fields['discount_price']->content){?>
                                    <span class="price "><?php echo $_smarty_tpl->getVariable('prod')->value->price;?>
 руб.</span>
                                <?php }else{ ?>
                                    <span class="price_old"><?php echo $_smarty_tpl->getVariable('prod')->value->price;?>
 руб.</span>
                                    <span class="price price_new"><?php echo $_smarty_tpl->getVariable('prod')->value->price;?>
 руб.</span>
                                <?php }?>
                            </div>
                        <div style="clear:both"></div>
                        </div>
                    </div>
                </div>
                <div class="bl-control--pack">
                        <?php if ($_smarty_tpl->getVariable('sizeTable')->value){?>
                            <div class="size">
                                <div class="clear"></div>
                                <ul class="ex-size">
                                    <?php  $_smarty_tpl->tpl_vars['cols'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['size'] = new Smarty_Variable;
 $_from = unserialize($_smarty_tpl->getVariable('prod')->value->fields['size']->content); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['cols']->key => $_smarty_tpl->tpl_vars['cols']->value){
 $_smarty_tpl->tpl_vars['size']->value = $_smarty_tpl->tpl_vars['cols']->key;
?>
                                        <?php if ($_smarty_tpl->tpl_vars['cols']->value['checked']){?>
                                            <?php if ($_smarty_tpl->tpl_vars['cols']->value['value']){?>
                                                <li class="sss sbig" data-id="<?php echo $_smarty_tpl->getVariable('prod')->value->prod_id;?>
-<?php echo $_smarty_tpl->tpl_vars['size']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['size']->value;?>

                                                                                                    </li>
                                            <?php }else{ ?>
                                                <li class="sss sbig" data-id=""><span style="opacity: 0.3;"><?php echo $_smarty_tpl->tpl_vars['size']->value;?>
</span>
                                                    <div class="titles">Нет в<br />наличии</div>
                                                </li>
                                            <?php }?>
                                        <?php }?>
                                    <?php }} ?>
                                </ul>
                            </div>
                        <?php }?>
                        <div class="clear"></div>
                        <div class="to-cart">
                            <a href="#" class="to-cart-bt" onclick="return Good.addTrash(this);"><b></b>Добавить в корзину</a>
                            <a href="javascript: return false;" class="select_size"><b></b>Выберите размер</a>
                        </div>
                        <div class="bl-favorite__product__link--wrapper">
                            <?php if (isset(D::$session['favorite'])&&in_array($_smarty_tpl->getVariable('prod')->value->prod_id,D::$session['favorite'])){?>
                                <a href="#" onclick="return FireFavorite.event(778, 'product', 'remove')"><i class="icon_star_product--favorite red"></i> товар добавлен</a>
                            <?php }else{ ?>
                                <a href="#" onclick="return FireFavorite.event(<?php echo $_smarty_tpl->getVariable('prod')->value->prod_id;?>
, 'product', 'add');"><i class="icon_star_product--favorite grey"></i> в избранное</a>
                            <?php }?>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="bl-top_card--wrapper">
                    <div class="bl-top_card--tabs">
                        <ul class="row tabs">
                            <li class="tabs-sizes__title">Таблица размеров</li>
                            <li class="col-25 active">Описание</li>
                            <li class="col-25 ">Доставка</li>
                            <li class="col-25 ">Оплата</li>
                            <li class="col-25 ">Гарантия</li>
                            <li class="col-25 ">Возврат</li>
                        </ul>
                    </div>
                </div>
            <div class="bl-info_tabs_card">
                <div class="text-wrapper tabs-sizes__body">
                    <div class="text-header col-25">Таблица размеров</div>
                    <div class="text bl-good--sdesc mCustomScrollbar _mCS_1 mCS_no_scrollbar" style="">
                        <div id="mCSB_1" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" style="max-height: 300px;" tabindex="0">
                            <div id="mCSB_1_container" class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y" style="position:relative; top:0; left:0;" dir="ltr">
                                <div class="size-table">
                                    <?php if ($_smarty_tpl->getVariable('prod')->value->category_code=='womenwear'){?>
                                        <?php $_template = new Smarty_Internal_Template('static;wear-women-sizes', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
                                    <?php }elseif($_smarty_tpl->getVariable('prod')->value->category_code=='manwear'){?>
                                        <?php $_template = new Smarty_Internal_Template('static;wear-men-sizes', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
                                    <?php }elseif($_smarty_tpl->getVariable('prod')->value->category_code=='manfootwear'){?>
                                        <?php $_template = new Smarty_Internal_Template('static;footwear-men-sizes', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
                                    <?php }elseif($_smarty_tpl->getVariable('prod')->value->category_code=='womenfootwear'){?>
                                        <?php $_template = new Smarty_Internal_Template('static;footwear-women-sizes', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
                                    <?php }elseif($_smarty_tpl->getVariable('prod')->value->fields['unisex']->content){?>
                                        <?php $_template = new Smarty_Internal_Template('static;wear-unisex-sizes', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
                                    <?php }?>
                                </div>
                            </div>
                            <div id="mCSB_1_scrollbar_vertical" class="mCSB_scrollTools mCSB_1_scrollbar mCS-light mCSB_scrollTools_vertical" style="display: none;">
                                <div class="mCSB_draggerContainer">
                                    <div id="mCSB_1_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; top: 0px;" oncontextmenu="return false;">
                                        <div class="mCSB_dragger_bar" style="line-height: 30px;"></div>
                                    </div>
                                    <div class="mCSB_draggerRail"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-wrapper">
                    <div class="text-header col-25 active">Описание</div>
                    <div class="text bl-good--sdesc mCustomScrollbar _mCS_2 mCS_no_scrollbar" style="display: block;">
                        <div id="mCSB_2" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" style="max-height: none;" tabindex="0">
                            <div id="mCSB_2_container" class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y" style="position:relative; top:0; left:0;" dir="ltr">
                                <?php echo $_smarty_tpl->getVariable('prod')->value->descr;?>

                            </div>
                            <div id="mCSB_2_scrollbar_vertical" class="mCSB_scrollTools mCSB_2_scrollbar mCS-light mCSB_scrollTools_vertical" style="display: none;">
                                <div class="mCSB_draggerContainer">
                                    <div id="mCSB_2_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; height: 0px; top: 0px;" oncontextmenu="return false;">
                                        <div class="mCSB_dragger_bar" style="line-height: 30px;"></div>
                                    </div>
                                    <div class="mCSB_draggerRail"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-wrapper">
                    <div class="text-header col-25 ">Доставка</div>
                    <div class="text bl-good--delivery_service">
                        <div>
                            <div class="bl-form-field">
                                <div class="bl-form-title">
                                Введите название Вашего населенного пункта
                                </div>
                                <div class="row-field" id="calc_city_form">
                                    <input onkeypress="" type="text" class="payinput" name="u_city" id="calc_city" value="" autocomplete="off" data-kladr-type="city" style="float: left;">
                                    <div id="load_image"></div>
                                    <input type="hidden" name="u_area" id="calc_area" value="" autocomplete="off" data-kladr-type="area">
                                    <input type="hidden" name="u_region" id="calc_region" value="" autocomplete="off" data-kladr-type="region">
                                    <input type="hidden" name="u_pref_region" id="pref_region" value="" autocomplete="off">
                                    <input type="hidden" name="u_pref_district" id="pref_district" value="" autocomplete="off">
                                    <input type="hidden" name="u_pref_city" id="pref_city" value="" autocomplete="off">
                                    <div class="clear"></div>
                                    <br><span style="color: red; display: none;" id="calc_city_error">Пожалуйста, проверьте написание</span>
                                </div>
                            </div>
                            <div id="result_calc"></div>
                        </div>
                    </div>
                </div>
                <div class="text-wrapper">
                    <div class="text-header col-25 ">Оплата</div>
                    <div class="text bl-text--information bl-pay--module bl-payment--tabs mCustomScrollbar _mCS_3 mCS_no_scrollbar" style="">
                        <div id="mCSB_3" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" style="max-height: 122px;" tabindex="0">
                            <div id="mCSB_3_container" class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y" style="position:relative; top:0; left:0;" dir="ltr">
                            <p>Оплатить данный товар Вы можете</p>
                            <p>- банковскими картами платежных систем: Visa, Mastercard</p>
                            <p>- наличными при получении</p>
                            <p>- с помощью сервиса Яндекс.Деньги</p>
                            <p class="mrt20">Подробнее в разделе <a href="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/static/pay">оплата</a></p>
                            </div>
                            <div id="mCSB_3_scrollbar_vertical" class="mCSB_scrollTools mCSB_3_scrollbar mCS-light mCSB_scrollTools_vertical" style="display: none;">
                                <div class="mCSB_draggerContainer">
                                    <div id="mCSB_3_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; top: 0px;" oncontextmenu="return false;">
                                        <div class="mCSB_dragger_bar" style="line-height: 30px;"></div>
                                    </div>
                                    <div class="mCSB_draggerRail"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-wrapper">
                    <div class="text-header col-25 ">Гарантия</div>
                    <div class="text bl-text--information mCustomScrollbar _mCS_4 mCS_no_scrollbar" style="">
                        <div id="mCSB_4" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" style="max-height: 305px;" tabindex="0">
                            <div id="mCSB_4_container" class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y" style="position:relative; top:0; left:0;" dir="ltr">
                                <p>Гарантия имеет силу при наличии &nbsp;чека, подтверждающего покупку.</p>
                                <p><span style="color: #f9210a;">Срок действия гарантии 30 дней</span> с момента получения заказа.&nbsp;</p>
                                <p>Гарантия на обувь не распространяется: на естественное истирание каблука и подошвы; на набойки, стельки, 
                                молнии, шнурки и другую фурнитуру; на эксплуатацию прошивной обуви в сырую погоду, так как обувь будет пропускать влагу (промокать),
                                прошивная обувь эксплуатируется только в сухую (весной и летом) и морозную (зимой) погоду; при изменении цвета кожи изделия
                                в результате попадания на нее различных жидкостей, кроме воды.&nbsp;</p>
                                <p>Гарантия не распространяется на обувь и изделия из кожи с дефектами, возникшими в следствие: несоблюдения условий
                                эксплуатации или ошибочных действий владельца изделия; несоблюдение условий ухода за изделием; неправильного хранения
                                (прямого солнечного света, хранения в сыром помещении и др.); попадание на изделие острых, горячих, холодных предметов;
                                попадание на изделие химических реагентов, способных изменить структуру кожи, окрас, размер, и др.; произведение ремонта
                                изделия самостоятельно или иными организациями; использование изделия не по назначению; эксплуатация обуви не в сезон;
                                уцененную обувь.&nbsp;</p>
                                <p>Гарантия на обувь не распространяется при несоблюдении условий эксплуатации и ухода за обувью.</p>
                                <p>Гарантийные условия соответствуют &nbsp;закону РФ «О защите прав потребителей»</p>
                            </div>
                            <div id="mCSB_4_scrollbar_vertical" class="mCSB_scrollTools mCSB_4_scrollbar mCS-light mCSB_scrollTools_vertical" style="display: none;">
                                <div class="mCSB_draggerContainer">
                                    <div id="mCSB_4_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; top: 0px;" oncontextmenu="return false;">
                                        <div class="mCSB_dragger_bar" style="line-height: 30px;"></div>
                                    </div>
                                    <div class="mCSB_draggerRail"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-wrapper">
                    <div class="text-header col-25 ">Возврат</div>
                    <div class="text bl-text--information mCustomScrollbar _mCS_5 mCS_no_scrollbar" style="">
                        <div id="mCSB_5" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" style="max-height: 193px;" tabindex="0">
                            <div id="mCSB_5_container" class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y" style="position:relative; top:0; left:0;" dir="ltr">
                            <p>Возврат товара надлежащего качества возможен:</p>
                            <p>&nbsp; &nbsp;- В течение 14-ти дней с момента получения товара</p>
                            <p>&nbsp; &nbsp;- Сохранен товарный вид изделия (в том числе оригинальная упаковка)<br><br><strong>Возврат осуществляется как по желанию Покупателя, так и из-за ошибки со стороны Продавца</strong></p>
                            <p>По вопросам возврата необходимо обратиться <span style="color: #f9210a;"><?php echo $_smarty_tpl->getVariable('config')->value['email'];?>
</span></p>
                            <p>Более подробная информация в разделе <span style="color: #888888;"><span style="text-decoration: underline;"><a href="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/static/obmen"><span style="color: #888888; text-decoration: underline;">обмен/возврат</span></a></span></span></p>
                            </div>
                            <div id="mCSB_5_scrollbar_vertical" class="mCSB_scrollTools mCSB_5_scrollbar mCS-light mCSB_scrollTools_vertical" style="display: none;">
                                <div class="mCSB_draggerContainer">
                                    <div id="mCSB_5_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; top: 0px;" oncontextmenu="return false;">
                                        <div class="mCSB_dragger_bar" style="line-height: 30px;"></div>
                                    </div>
                                    <div class="mCSB_draggerRail"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>