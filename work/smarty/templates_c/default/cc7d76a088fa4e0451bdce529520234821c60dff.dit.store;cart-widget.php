<?php /* Smarty version Smarty3-RC3, created on 2018-07-09 14:12:33
         compiled from "dit:store;cart-widget" */ ?>
<?php /*%%SmartyHeaderCode:17260459925b4327015436e4-80620818%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cc7d76a088fa4e0451bdce529520234821c60dff' => 
    array (
      0 => 'dit:store;cart-widget',
      1 => 1531126801,
    ),
  ),
  'nocache_hash' => '17260459925b4327015436e4-80620818',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="bl-after_add_trash--wrapper">
    <?php if (isset($_smarty_tpl->getVariable('addedProduct')->value)){?>
        <div class="add_small--wrapper">
            <h4>Добавлено в Вашу корзину</h4>
            <div class="bl-info_good--wrapper">
                <div class="bl-img">
                    <img style="height:80px;" class="product_image" src="<?php echo $_smarty_tpl->getVariable('me')->value['content'];?>
/media/thumbs/product<?php echo $_smarty_tpl->getVariable('addedProduct')->value->prod_id;?>
/<?php echo $_smarty_tpl->getVariable('addedProduct')->value->picture->fileid;?>
" />
                </div>
                <div class="bl-info">
                    <span class="name"><?php echo $_smarty_tpl->getVariable('addedProduct')->value->prod_name;?>
</span>
                    <span class="param">Размер:<?php echo $_smarty_tpl->getVariable('addedProduct')->value->size;?>
</span>
                    <span class="param">Количество: 1</span>
                    <span class="price"><?php echo $_smarty_tpl->getVariable('addedProduct')->value->price;?>
 руб.</span> 
                </div>
            </div>
        </div>
    <?php }?>
</div>
<script>
    $(document).ready(function(){
        var doc_h 			= $(window).height();
        var cnt_in_trash 	= $("#cnt_good_in_trash").val();
        if(doc_h < 800){
            var h = 320;
            var v = 2;
            if(window.innerHeight <= 768){
                v = 1;
                h = 160;
                $(".bl-list_trash--container .items.slider_wrapper .items_wrapper").css("height", "160px");
            }else{
                $(".bl-list_trash--container .items.slider_wrapper .items_wrapper").css("height", "320px");
            }
            $('.items').vaccordion({
                accordionW: 294,
                accordionH: h,
                expandedHeight	: 162,
                visibleSlices: v
            });
        } else{
            var h = 480;
            var v = 3;
            if(window.innerHeight <= 768){
                v = 1;
                h = 160;
            }
            if(cnt_in_trash < 4){
                $('.items').removeClass("slider_wrapper");
            }
            if(cnt_in_trash > 3){
                $('.items').vaccordion({
                    accordionW: 294,
                    accordionH: h,
                    expandedHeight	: 162,
                    visibleSlices: v
                });
            }
        }
    });
</script>
<?php $_smarty_tpl->tpl_vars['cart'] = new Smarty_variable(Store_Cart::getCart(), null, null);?>
<?php $_smarty_tpl->tpl_vars['total'] = new Smarty_variable(Store_Cart::getCartSum(), null, null);?>
<input type="hidden" id="cnt_good_in_trash" value="<?php echo $_smarty_tpl->getVariable('total')->value['total_quantity'];?>
">
<?php if ($_smarty_tpl->getVariable('cart')->value){?>
    <div class="bl-small_trash--wrapper canopen">
        <div class="header_small_trash" onclick="window.location.href = '/store/order'; return false;">
            <i></i>
            <span class="cnt_trash"><?php echo $_smarty_tpl->getVariable('total')->value['total_quantity'];?>
</span>
        </div>
        <div class="bl-list_trash--wrapper">
            <div class="bl-list_trash--container">
                <h4>Добавлено в Вашу корзину</h4>
                <div class="items slider_wrapper" style="width: 294px; height: 160px;">
                    <?php if ($_smarty_tpl->getVariable('total')->value['total_quantity']>2){?>
                        <div class="va-nav">
                            <div class="va-nav-prev"><span class="va-nav-prev-span">Previous</span></div>
                            <div class="va-nav-next" style="display: block;"><span class="va-nav-next-span">Next</span></div>
                        </div>
                    <?php }?>
                    <div class="items_wrapper" style="height: 160px;">
                        <?php  $_smarty_tpl->tpl_vars['pack'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['pack_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('cart')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['pack']->key => $_smarty_tpl->tpl_vars['pack']->value){
 $_smarty_tpl->tpl_vars['pack_id']->value = $_smarty_tpl->tpl_vars['pack']->key;
?>
                            <?php $_smarty_tpl->tpl_vars['pack_summ'] = new Smarty_variable(0, null, null);?>
                            <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['hash'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['pack']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value){
 $_smarty_tpl->tpl_vars['hash']->value = $_smarty_tpl->tpl_vars['data']->key;
?>
                                <?php if ($_smarty_tpl->tpl_vars['data']->value['visible']){?>
                                    <?php $_smarty_tpl->tpl_vars['prod_id'] = new Smarty_variable($_smarty_tpl->tpl_vars['data']->value['prod_id'], null, null);?>
                                    <?php $_smarty_tpl->tpl_vars['prod'] = new Smarty_variable(D_Core_Factory::Store_Product($_smarty_tpl->getVariable('prod_id')->value), null, null);?>
                                    <div class="item va-slice" id="aa43d2877fdd0de47c80bce70e7bd0e3" style="top: 160px; height: 160px;">
                                        <i onclick="Trash.delItemSmallTrash('aa43d2877fdd0de47c80bce70e7bd0e3'); return false; void(0);"></i>
                                        <div class="bl-img">
                                            <a href="#" class="cart-photo">
                                                <img style="height:80px;" class="product_image" src="<?php echo $_smarty_tpl->getVariable('me')->value['content'];?>
/media/thumbs/product<?php echo $_smarty_tpl->getVariable('prod')->value->prod_id;?>
/<?php echo $_smarty_tpl->getVariable('prod')->value->picture->fileid;?>
" /></a>
                                        </div>
                                        <div class="bl-info">
                                            <span class="name"><?php echo $_smarty_tpl->getVariable('prod')->value->prod_name;?>
</span>
                                            <span class="param">Размер: <?php echo $_smarty_tpl->tpl_vars['data']->value['size'];?>
</span>
                                            <span class="param">Количество: <?php echo $_smarty_tpl->tpl_vars['data']->value['quantity'];?>
</span>
                                            <span class="price"><?php echo $_smarty_tpl->getVariable('prod')->value->current_price;?>
 руб.</span>
                                        </div>
                                    </div>
                                <?php }?>
                            <?php }} ?>
                        <?php }} ?>
                    </div>
                </div>
                <div class="list_trash--footer">
                    <div class="total_price">
                        <div class="label"><span>Стоимость:</span></div>
                        <div class="value"><span><?php echo $_smarty_tpl->getVariable('total')->value['total_cost'];?>
 руб.</span></div>
                    </div>
                    <a href="/store/order">Оформить заказ</a>
                </div>
            </div>
        </div>
    </div>
<?php }else{ ?>
    <div class = "bl-small_trash--wrapper">
        <div class = 'header_small_trash'>
            <i></i>
        </div>
    </div>
<?php }?>