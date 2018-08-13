<div id="modal_header">
	<div id="modal_header_links"><span><{if $cur_category=='food'}>Меню<{else}>Ингридиенты<{/if}></span></div>
<a class="modal_navi_close" href="#"></a>	
</div>
<div id="modal_slider">
<a href="<{$me.www}>/store/show-nextproduct/<{$cur_category}>/product_<{$prod->prod_id}>/mode_prev" class="modal_nav modal_prev"></a>
<a href="<{$me.www}>/store/show-nextproduct/<{$cur_category}>/product_<{$prod->prod_id}>/mode_next" class="modal_nav modal_next"></a>
<div id="modal_content">
	<div class="product_show" >
		<div class="product_show_image">
			<a href="<{$me.www}>/store/show-nextproduct/<{$cur_category}>/product_<{$prod->prod_id}>/mode_next" title="<{$prod->prod_name}>" class="modal_nav">
				<img src="<{$me.content}>/media/product<{$prod->prod_id}>/<{$prod->picture->fileid}>" alt="<{$prod->prod_name}>" /></a>
		</div>
		<div class="product_show_discr">
			<a class="product_show_link" href="#"><{$prod->prod_name}></a><br />
			<span class="product_show_weight psw_current"><{$prod->weight}>гр. <{$prod->psc}>шт.</span><br />
			<div class="product_show_text">
				<{if $prod->staff}><p><b>Состав:</b> <{$prod->staff}></p><br /><{/if}>
				<{if $prod->descr}><p><b>Описание:</b> <{$prod->descr}></p><br /><{/if}>
				<{if $prod->reciple}><p><b>Рецепт:</b> <{$prod->reciple}></p><{/if}>
			</div>
			<form style="position:relative; z-index:1010;" class="add-cart" action="<{$me.www}>/store/add-to-cart/product_<{$prod->prod_id}>" method="post">
				<span class="pd_price">
					<input name="quantity" value="1" align="right" type="text" /><span><{$prod->price}><span class="pd_rub">&#8399;</span><span class="pd_black">/<{if $main_category=='food'}>порция<{else}>шт.<{/if}></span></span>
			    </span>
				<input class="bybtn product_show_buy_btn" type="submit" value="" />
			</form>
		</div>
	</div>
</div>
</div>