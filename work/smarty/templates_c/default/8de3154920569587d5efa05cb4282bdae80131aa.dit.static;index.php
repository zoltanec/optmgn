<?php /* Smarty version Smarty3-RC3, created on 2018-07-09 14:12:33
         compiled from "dit:static;index" */ ?>
<?php /*%%SmartyHeaderCode:19651157195b4327017ff554-76576411%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8de3154920569587d5efa05cb4282bdae80131aa' => 
    array (
      0 => 'dit:static;index',
      1 => 1531126802,
    ),
  ),
  'nocache_hash' => '19651157195b4327017ff554-76576411',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="main" class="mt114">
    <div class="sliderr">
        <div class="slides">
            <?php  $_smarty_tpl->tpl_vars['slide'] = new Smarty_Variable;
 $_from = Slider_Slideshow::getActive(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['slide']->key => $_smarty_tpl->tpl_vars['slide']->value){
?>
                <div class="slide">
                    <div class="slider-inner">
                        <div>
                            <a class="linkBanner" data="82" href = '<?php echo $_smarty_tpl->getVariable('slide')->value->url;?>
'>
                                <img src="<?php echo $_smarty_tpl->getVariable('me')->value['content'];?>
/slider/slides/<?php echo $_smarty_tpl->getVariable('slide')->value->image;?>
" />
                            </a>
                            <div class="text-fon">
                                <p class="sl-title"><?php echo $_smarty_tpl->getVariable('slide')->value->title;?>
</p>
                                <div class="sl-desc"><?php echo $_smarty_tpl->getVariable('slide')->value->short;?>
</div>
                            </div>
                            <div class="text-fon-short">
                                <p class="sl-title"></p>
                                 <div class="sl-desc"><a href="<?php echo $_smarty_tpl->getVariable('slide')->value->url;?>
" class="linkBanner"></a></div>
                            </div>
                        </div>	
                    </div>
                </div>
             <?php }} ?>
        </div>
    </div>
</div>