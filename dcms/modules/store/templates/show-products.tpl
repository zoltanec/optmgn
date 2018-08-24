<{if $products->total_pages > 1}>
 <div id="pages">
 Страницы:
  <{foreach item=page from=$products->pager2()}>
  <{if $page==$products->page}>
  	<span class="selected_page"><{$page}></span>
  <{else}>
  	<a class="page_link" title="<{$page}>"><{$page}></a>
  <{/if}>
  <{/foreach}>
 </div>
<{/if}>
<{if $products->total=='0'}>
	По данным критериям не найдены
<{/if}>
<{foreach item=prod from=$products}>
	<{assign var='poster' value=dObject::MediaDir("product`$prod->prod_id`")->poster}>
	<div class="item item1">
                        <h2><a class="title" href="<{$me.www}>/store/show-product/product_<{$prod->prod_id}>"><{$prod->prod_name}></a></h2>
                        <div class="bcont">
                            <div class="img"><img width="58" alt="<{$prod->prod_name}>" src="<{$me.content}>/media/product<{$prod->prod_id}>/<{$poster->fileid}>"></div>
                            <div class="price">
                                <span class="pr"><{$prod->price}>Р</span>
				<span class="else"><{$prod->category_name}></span>
				<div class="vote vote1">
		                            <img src="<{$theme.images}>/10bstars.png">
		                        </div>
                            </div>
			    
                        </div>
			<div style="float:right;">
			
                        <input class="quantity" type="text" name="quantity" value="1"/>
			<a class="blue-button" href="<{$me.www}>/store/add-to-cart/prodid_<{$prod->prod_id}>"><b><em>Купить</em></b></a>
			</div>
        </div>
<{/foreach}>