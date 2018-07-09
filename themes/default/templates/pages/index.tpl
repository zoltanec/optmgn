<{if $req->action=='contacts'}>
<div class="pull">
 
 <div class="titles"><span><{$page->title}></span></div>
 
 <div class="contact_left">
    <div class="text_block">
    <{$page->content_html}>
    </div>
 </div>
 <div class="contact_right">
  <{include file='feedback;index'}>
  
 </div> </div>
    <script type="text/javascript">function fid_1356788743013377419104(ymaps) {var map = new ymaps.Map("ymaps-map-id_1356788743013377419104", {center: [58.991863291829944, 53.36755014832452], zoom: 15, type: "yandex#map"});map.controls.add("zoomControl").add("mapTools").add(new ymaps.control.TypeSelector(["yandex#map", "yandex#satellite", "yandex#hybrid", "yandex#publicMap"]));map.geoObjects.add(new ymaps.Placemark([58.9974758055737, 53.36651924697084], {balloonContent: "Здесь стоит здание автовокзала, в котором находимся мы, но его почему-то нет на карте."}, {preset: "twirl#redDotIcon"}));};</script>
<script type="text/javascript" src="http://api-maps.yandex.ru/2.0-stable/?lang=ru-RU&amp;coordorder=longlat&amp;load=package.full&amp;wizard=constructor&amp;onload=fid_1356788743013377419104"></script>
<div id="ymaps-map-id_1356788743013377419104" style="width: 100%; height: 600px;"></div>
<{else}>
<div id="content">
<div class="pull">
 <div class="titles"><span><{$page->title}></span></div>
 <div class="text_block">
	<{$page->content_html}>
	<{if $page->comments}>
	 <{include object_id=$page->object_id() file="comments;comments"}>
	<{/if}>
 </div>
</div></div>
<{/if}>