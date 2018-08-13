<script type="text/javascript" src="<{$config->jscripts_url}>/pages.functions.js"></script>
<{if D::$config->setting->breadcrumbs == true}>
	<div class="breadcrumbs">
		<a href="<{$me.www}>" title="Главная">Главная</a> <span>></span>
		<{foreach item=breadcrumb from=$tpl->getBreadCrumbs()}>
			<a href="<{$breadcrumb.link}>" title="<{$breadcrumb.name}>"><{$breadcrumb.name}></a> <span>></span>
		<{/foreach}>
		<b><{$page->title}></b>
	</div>
<{/if}>
<h1><{$page->pagetitle}></h1>
<{*div id="content"*}>
<{if D::$config->setting->time == true}>
	<{$page->add_time}>
<{/if}>
<{if D::$config->setting->author == true}>
	<{$page->user}>
<{/if}>
<{$page->content_html}>
<{if $page->comments}>
 <{include object_id=$page->object_id() file="comments;comments"}>
<{/if}>
<{*Получение списка дочерних страниц, если указан тип. Перенести в отдельный шаблон, возможность указать свой*}>
<{if $page->template && $page->content_type!='document'}>
		<{include file="dit:pages;`$page->template`"}>
<{/if}>
<{if $page->content_type=='document-list'}>
	<{foreach item=child_page from=$page->activeChildren}>
	<div class="contain_child">
		<p>
			<a href="<{$me.www}>/<{$child_page->HURL}>" title="<{$child_page->menutitle}>">
				<span><{$child_page->thumb_icon}></span>
				<{$child_page->pagetitle}>
			</a>
			<br /><{$child_page->annotation}>
		</p>
	</div>
	<{/foreach}>
<{elseif $page->content_type=='accordion-list'}>
	<{foreach item=child_page from=$page->activeChildren}>
	<div class="accordion_child">
		<div class="accordion tree_node">
			<a href="<{$me.www}>/<{$child_page->HURL}>" title="<{$child_page->menutitle}>" data-id="<{$child_page->content_id}>" data-object-id="<{$child_page->object_id()}>">
				<span><{$child_page->icon}></span><span><{$child_page->pagetitle}></span>
			</a>
		</div>
		<div class="accordion_dynamic">
			<p>
			<span><{$child_page->icon}></span>
			<{$child_page->annotation}>
			<a href="<{$me.www}>/<{$child_page->HURL}>" title="<{$child_page->menutitle}>">Подробнее</a></p>
		</div>
	</div>
	<{/foreach}>
<{elseif $page->content_type=='list-n-content'}>
	<div class="child_links">
	<{foreach item=child_page from=$page->activeChildren}>
		<div class="child_link tree_node">
			<a class="node" href="<{$me.www}>/<{$child_page->HURL}>" title="<{$child_page->menutitle}>" data-id="<{$child_page->content_id}>" data-object-id="<{$child_page->object_id()}>">
				<span><{$child_page->icon}></span><span><{$child_page->pagetitle}></span>
			</a>
		</div>
		<div class="accordion_dynamic">
			<p>
			<span><{$child_page->icon}></span>
			<{$child_page->annotation}>
			<a href="<{$me.www}>/<{$child_page->HURL}>" title="<{$child_page->menutitle}>">Подробнее</a></p>
		</div>
	<{/foreach}>
	</div>
	<div id="page_content">
	</div>
<{elseif $page->content_type=='tabs'}>
	<ul class="tabs">
	<{foreach item=child_page from=$page->activeChildren}>
		<li class="tab tree_node">
			<a class="node" href="<{$me.www}>/<{$child_page->HURL}>" title="<{$child_page->menutitle}>" data-id="<{$child_page->content_id}>" data-object-id="<{$child_page->object_id()}>">
				<{$child_page->icon}>
				<p><{$child_page->menutitle}></p>
			</a>
		</li>
	<{/foreach}>
	</ul>
	<div id="page_content">

	</div>
<{/if}>
<{if $req->action=='contacts'}>
Схема проезда
<div id="map"></div>
<{/if}>