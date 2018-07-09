<div id="content" class="clearfix">
    <link href="<{$theme.css}>/catalog/trash.css" rel="stylesheet" type="text/css"/>
    <link href="<{$theme.css}>/catalog/order.css" rel="stylesheet" type="text/css"/>
    <link href="<{$theme.css}>/catalog/catalog.css" rel="stylesheet" type="text/css"/>
    <link href="<{$config->jscripts_path}>/theme/jquery.mCustomScrollbar.min.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="<{$config->jscripts_path}>/theme/scrolltotop.js"></script>
    <script type="text/javascript" src="<{$config->jscripts_path}>/theme/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="<{$config->jscripts_path}>/theme/catalog/order.js"></script>
    <script type="text/javascript" src="<{$config->jscripts_path}>/theme/catalog/catalog.js"></script>
    <div class="content w1024">
        <div class="item-info">
            <{if $prod->fields['new']->content}>
                <div class="shild-left novinka_cart"></div>
            <{/if}>
            <{if $prod->fields['club']->content}>
                <div class="shild-left club_cart" onclick="return Good.scrollToClub();"></div>
            <{/if}>
            <{if $prod->fields['sale']->content}>
                <div class="shild-left skidka_ico_cart sale990"></div>
            <{/if}>
            <div class="item-photo owl-carousel owl-theme owl-center owl-loaded" style="visibility: hidden;">
                <{foreach name=pictures item=picture from=$prod->pictures}>
                    <{*div class="owl-item" style="width: 1024px; margin-right: 0px;"*}>
                        <a id="big-photo" class="fancy_ex" rel="good" href="<{$me.content}>/media/product<{$prod->prod_id}>/<{$picture->fileid}>">
                            <img src="<{$me.content}>/media/thumbs/product<{$prod->prod_id}>/<{$picture->fileid}>" alt="<{$prod->prod_name}>">
                        </a>
                <{/foreach}>
            </div>
            <div class="clear"></div>
            <div class="bl-good_cart--center">
                <div class="bl-control--card">
                    <div class="bl-info_good--header">
                        <div class="info">
                            <h1 class="maker"><{$prod->prod_name}></h1>
                        </div>
                    </div>
                    <div class="bl-table_size">
                    
                        <{if $prod->category_code == 'womenwear'}>
                            <{assign var=sizeTable value='wear-women-sizes'}>
                        <{elseif $prod->category_code == 'manwear'}>
                            <{assign var=sizeTable value='wear-men-sizes'}>
                        <{elseif $prod->category_code == 'manfootwear'}>
                            <{assign var=sizeTable value='footwear-men-sizes'}>
                        <{elseif $prod->category_code == 'womenfootwear'}>
                            <{assign var=sizeTable value='footwear-women-sizes'}>
                        <{elseif $prod->fields['unisex']->content}>
                            <{assign var=sizeTable value='wear-unisex-sizes'}>
                        <{/if}>
                        <{if $sizeTable}>
                            <a href="javascript: ins_ajax_open('/static/<{$sizeTable}>', 0, 0, 0); void(0);" class="size-link">Таблица размеров</a>
                        <{/if}>
                    </div>
                    <div class="bl-info_cost--header">
                        <div class="cost">
                            <div>
                                <{if !$prod->fields['discount_price']->content}>
                                    <span class="price "><{$prod->price}> руб.</span>
                                <{else}>
                                    <span class="price_old"><{$prod->price}> руб.</span>
                                    <span class="price price_new"><{$prod->price}> руб.</span>
                                <{/if}>
                            </div>
                        <div style="clear:both"></div>
                        </div>
                    </div>
                </div>
                <div class="bl-control--pack">
                        <{if $sizeTable}>
                            <div class="size">
                                <div class="clear"></div>
                                <ul class="ex-size">
                                    <{foreach item=cols key=size from=unserialize($prod->fields['size']->content)}>
                                        <{if $cols['checked']}>
                                            <{if $cols['value']}>
                                                <li class="sss sbig" data-id="<{$prod->prod_id}>-<{$size}>"><{$size}>
                                                    <{*div class="titles"><b>25.5</b> CM</div*}>
                                                </li>
                                            <{else}>
                                                <li class="sss sbig" data-id=""><span style="opacity: 0.3;"><{$size}></span>
                                                    <div class="titles">Нет в<br />наличии</div>
                                                </li>
                                            <{/if}>
                                        <{/if}>
                                    <{/foreach}>
                                </ul>
                            </div>
                        <{/if}>
                        <div class="clear"></div>
                        <div class="to-cart">
                            <a href="#" class="to-cart-bt" onclick="return Good.addTrash(this);"><b></b>Добавить в корзину</a>
                            <a href="javascript: return false;" class="select_size"><b></b>Выберите размер</a>
                        </div>
                        <div class="bl-favorite__product__link--wrapper">
                            <{if isset(D::$session['favorite']) && in_array($prod->prod_id, D::$session['favorite'])}>
                                <a href="#" onclick="return FireFavorite.event(778, 'product', 'remove')"><i class="icon_star_product--favorite red"></i> товар добавлен</a>
                            <{else}>
                                <a href="#" onclick="return FireFavorite.event(<{$prod->prod_id}>, 'product', 'add');"><i class="icon_star_product--favorite grey"></i> в избранное</a>
                            <{/if}>
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
                                    <{if $prod->category_code == 'womenwear'}>
                                        <{include file='static;wear-women-sizes'}>
                                    <{elseif $prod->category_code == 'manwear'}>
                                        <{include file='static;wear-men-sizes'}>
                                    <{elseif $prod->category_code == 'manfootwear'}>
                                        <{include file='static;footwear-men-sizes'}>
                                    <{elseif $prod->category_code == 'womenfootwear'}>
                                        <{include file='static;footwear-women-sizes'}>
                                    <{elseif $prod->fields['unisex']->content}>
                                        <{include file='static;wear-unisex-sizes'}>
                                    <{/if}>
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
                                <{$prod->descr}>
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
                            <p class="mrt20">Подробнее в разделе <a href="<{$me.www}>/static/pay">оплата</a></p>
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
                            <p>По вопросам возврата необходимо обратиться <span style="color: #f9210a;"><{$config.email}></span></p>
                            <p>Более подробная информация в разделе <span style="color: #888888;"><span style="text-decoration: underline;"><a href="<{$me.www}>/static/obmen"><span style="color: #888888; text-decoration: underline;">обмен/возврат</span></a></span></span></p>
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