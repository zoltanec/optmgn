<div id="content" class="clearfix w100p">
    <script type="text/javascript" src="<{$config->jscripts_path}>/theme/icontent.js"></script>
    <link href="<{$theme.css}>/icontent.css" rel="stylesheet" type="text/css">
    <{*link href="<{$config->jscripts_path}>/theme/jquery.mCustomScrollbar.min.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="<{$config->jscripts_path}>/theme/jquery.mCustomScrollbar.concat.min.js"></script*}>
    <{if $news->content_preview != ' '}>
        <div class="content bl-news--wrapper">
            <div class="bl-header">
                <div class="bl--title">
                    <h1 class="news-h"><{$t.news->title}></h1>
                </div>
                <div class="bl--info">
                    <span class="date"><{$t.news->addtime|convert_time}></span>
                    <span class="count"><img src="<{$theme.images}>/eye.svg"> <{$news->readed}></span>
                    <div style="display: inline-block; width: 115px; height: 18px; background: none; position: relative; clear: both;" id="like_content">
                        <div id="vk_like"></div>
                        <script type="text/javascript">
                        VK.Widgets.Like("vk_like", {type: "mini", height: 20});
                        </script>
                    </div>
                </div>
            </div>
            <div class="bl-content--wrapper mCustomScrollbar _mCS_1 mCS_no_scrollbar">
                
                <div id="mCSB_1" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" style="max-height: none;" tabindex="0">
                    <div id="mCSB_1_container" class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y" style="position:relative; top:0; left:0;" dir="ltr">
                        <div class = "bl-media_info--wrapper">
                            <{if $section->section_name != 'Видео'}>
                                <div class = "bl-slider--wrapper slider-inner">
                                    <{foreach item=slide from=$news->__sliders()}>
                                        <img src="<{$slide}>" alt="<{$t.news->title}>" >
                                    <{/foreach}>
                                </div>
                                <p class="img-identity">Все фотографии товара подлинные. Полное или частичное копирование с письменного разрешения правообладателя <{$config.site_name}></p>
                            <{else}>
                                <div class="video-container">
                                    <iframe src="<{$news->source}>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                </div>
                            <{/if}>
                        </div>
                        <div class="bl-info--wrapper">
                            <div class="bl-content--wrapper  mCustomScrollbar _mCS_2 mCS_no_scrollbar">
                                <div id="mCSB_2" 
                                    class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" 
                                    style="max-height: none;" 
                                    tabindex="0">
                                    <div id="mCSB_2_container" 
                                        class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y" 
                                        style="position:relative; top:0; left:0;" 
                                        dir="ltr">
                                        <p><strong><{$t.news->content_preview}></strong></p>
                                        <{if $t.news->mode=='html'}>
                                            <{$t.news->content}>
                                        <{else}>
                                            <{$t.news->content|bbcode}>
                                        <{/if}>
                                    </div>
                                    <div id="mCSB_2_scrollbar_vertical" class="mCSB_scrollTools mCSB_2_scrollbar mCS-light mCSB_scrollTools_vertical" style="display: none;">
                                        <div class="mCSB_draggerContainer">
                                            <div id="mCSB_2_dragger_vertical" 
                                                class="mCSB_dragger" 
                                                style="position: absolute; min-height: 30px; height: 0px; top: 0px;" 
                                                oncontextmenu="return false;">
                                            <div class="mCSB_dragger_bar" style="line-height: 30px;"></div>
                                        </div>
                                        <div class="mCSB_draggerRail"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="mCSB_1_scrollbar_vertical" class="mCSB_scrollTools mCSB_1_scrollbar mCS-light mCSB_scrollTools_vertical" style="display: none;">
                    <div class="mCSB_draggerContainer">
                        <div id="mCSB_1_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; height: 0px; top: 0px;" oncontextmenu="return false;">
                            <div class="mCSB_dragger_bar" style="line-height: 30px;">
                            </div>
                        </div>
                        <div class="mCSB_draggerRail"></div>
                    </div>
                </div>
            </div>
        </div>	
        <div class="clearfix"></div>
    <{else}>
        <div class="bl-old_news--wrapper">
            <div class="content w730">
                <div class="statica">
                    <h1 class="news-h"><{$t.news->title}></h1>
                    <{$t.news->content}>
                </div>	
            </div>	
        </div>
    <{/if}>
</div>