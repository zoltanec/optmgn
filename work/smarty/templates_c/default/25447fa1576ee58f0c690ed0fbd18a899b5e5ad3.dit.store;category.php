<?php /* Smarty version Smarty3-RC3, created on 2018-07-09 18:22:21
         compiled from "dit:store;category" */ ?>
<?php /*%%SmartyHeaderCode:10137027805b43618d898798-34277163%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '25447fa1576ee58f0c690ed0fbd18a899b5e5ad3' => 
    array (
      0 => 'dit:store;category',
      1 => 1531142488,
    ),
  ),
  'nocache_hash' => '10137027805b43618d898798-34277163',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (count($_smarty_tpl->getVariable('products')->value)){?>
    <?php  $_smarty_tpl->tpl_vars['prod'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('products')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['prod']->key => $_smarty_tpl->tpl_vars['prod']->value){
?>
    <div class="goods-list__item goods-card ga_item" id="" data-entity="items-row" data-product_id="">
        <div class="goods-card__frame">
            <a class="goods-card__link" 
            href="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/store/show-product/product_<?php echo $_smarty_tpl->getVariable('prod')->value->prod_id;?>
" 
            title="<?php echo $_smarty_tpl->getVariable('prod')->value->prod_name;?>
"
            data-prod-id="<?php echo $_smarty_tpl->getVariable('prod')->value->prod_id;?>
" 
            data-prod-price="<?php echo $_smarty_tpl->getVariable('prod')->value->current_price;?>
"
            data-entity="image-wrapper">
                <div class="goods-card__img-wrap">
                    <img class="goods-card__img" src="http://sportlandshop.ru/content/media/thumbs/product<?php echo $_smarty_tpl->getVariable('prod')->value->prod_id;?>
/<?php echo $_smarty_tpl->getVariable('prod')->value->picture->fileid;?>
" alt="<?php echo $_smarty_tpl->getVariable('prod')->value->prod_name;?>
" >
                    <div class="goods-labels goods-card__labels">
                        <div class="goods-labels__list">
                            <?php if ($_smarty_tpl->getVariable('prod')->value->fields['new']->content){?>novinka skidka_prew<?php }?>
                            <?php if ($_smarty_tpl->getVariable('prod')->value->fields['club']->content){?>club club_prew<?php }?>
                            <?php if ($_smarty_tpl->getVariable('prod')->value->fields['sale']->content){?>discount-ico skidka_prew sale990<?php }?>
                            <div class="icon goods-labels__item goods-label goods-label_new" title="Новинки"></div>
                        </div>
                    </div>
                </div>
                <div class="goods-card__brand">
                    <?php if ($_smarty_tpl->getVariable('prod')->value->fields['brand']->content){?>
                        <?php echo $_smarty_tpl->getVariable('prod')->value->fields['brand']->content;?>

                    <?php }else{ ?>
                        <?php echo preg_replace("#(.*?)\s.*#","$"."1",$_smarty_tpl->getVariable('prod')->value->prod_name);?>

                    <?php }?>
                </div>
                <div class="goods-card__name"><?php echo $_smarty_tpl->getVariable('prod')->value->prod_name;?>
</div>
                <div class="goods-card__price price">
                    от <span class="price__value" id=""><?php echo $_smarty_tpl->getVariable('prod')->value->fields['wholesale-box-price']->content;?>
</span> руб./шт</div>
                <div class="goods-card__price_old price price_old hidden">
                    от <span class="price__value" id=""></span><?php echo $_smarty_tpl->getVariable('prod')->value->fields['wholesale-price']->content;?>
 руб./шт</div>
            </a>
            <div class="goods-card__hover">
                <div class="goods-card__put">
                    <div class="put put_sm to-cart-block">
                        <div class="product-item-info-container product-item-hidden" data-entity="quantity-block">
                            <div class="put__counter" data-toggle="tooltip" data-original-title="">
                                <a class="put__arrow put__arrow_minus product-item-amount-field-btn-disabled" id="bx_3966226736_1408701_7e1b8e3524755c391129a9d7e6f2d206_quant_down" href="javascript:void(0)" rel="nofollow">
                                </a>
                                <input class="put__input" id="" type="tel" name="quantity" value="1" disabled="disabled">
                                <a class="put__arrow put__arrow_plus product-item-amount-field-btn-disabled" id="" rel="nofollow">
                                </a>
                            </div>
                        </div>
                        <div id="">
                            <div class="put__btn 
                                btn 
                                btn_primary 
                                btn_size_xs 
                                product_add_to_basket_opt 
                                to-cart">В корзину</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php }} ?>
<?php }?>