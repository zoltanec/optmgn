<div class="container l-goods-l">
	<div class="row l-goods-l__header"><div class="col-item"><h1 class="title-h1">Обувь оптом</h1></div></div>
	<div class="row l-goods-l__section">
		<div class="col-item l-goods-l__filters">
			<div class="collapse filters-wrap" id="filters">
				<div class="filters__item bx_filter_parameters_box " data-expanded="Y" data-prop_code="type" property_id="334">
					<div class="filters__title" data-toggle="collapse" data-target="#filter_type">
						<div data-toggle="tooltip" title="" data-original-title="">Категория</div>
					</div>
					<div class="filters__block collapse in" id="filter_type">
						<div class="bx_filter_parameters_box_container ">
							<label class="filters__search icon icon-zoom">
								<input class="filters__search-input input-text" type="text" placeholder="Поиск..." data-search="#filterItemsTYPE" name="filter_elements">
							</label>
							<div class="filters__contain scroller mCustomScrollbar _mCS_1">
								<div id="mCSB_1" class="mCustomScrollBox mCS-inset mCSB_vertical mCSB_inside" style="max-height: 300px;" tabindex="0">
									<div id="mCSB_1_container" class="mCSB_container" style="position:relative; top:0; left:0;" dir="ltr">
										<div class="scroller__content" id="filterItemsTYPE">
											<label class="checkbox " data-role="label_SMART_FILTER_334_3484748419" for="SMART_FILTER_334_3484748419">
												<input class="checkbox__input" type="checkbox" value="Y" name="SMART_FILTER_334_3484748419" id="SMART_FILTER_334_3484748419" onclick="smartFilter.click(this)">
												<span class="checkbox__text">Балетки&nbsp;(<span data-role="count_SMART_FILTER_334_3484748419">618</span>)</span>
											</label>
											<label class="checkbox " data-role="label_SMART_FILTER_334_651603894" for="SMART_FILTER_334_651603894">
												<input class="checkbox__input" type="checkbox" value="Y" name="SMART_FILTER_334_651603894" id="SMART_FILTER_334_651603894" onclick="smartFilter.click(this)">
												<span class="checkbox__text">Босоножки&nbsp;(<span data-role="count_SMART_FILTER_334_651603894">1128</span>)</span>
											</label>																			
										</div>
									</div>
									<div id="mCSB_1_scrollbar_vertical" class="mCSB_scrollTools mCSB_1_scrollbar mCS-inset mCSB_scrollTools_vertical" style="display: block;">
										<div class="mCSB_draggerContainer">
											<div id="mCSB_1_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; display: block; height: 84px; max-height: 290px; top: 0px;">
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
		<div class="col-item l-goods-l__goods ">
			<{include file="store;slider.tpl" productList=$hit  sliderTitle="Хиты продаж"}>
			<{include file="store;slider.tpl" productList=$new  sliderTitle="Новинки"}>
			<{include file="store;slider.tpl" productList=$sale sliderTitle="Распродажа"}>
		</div>
	</div>
</div>
