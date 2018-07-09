<div id="main" class="mt114">
    <div class="sliderr">
        <div class="slides">
            <{foreach name=slides item=slide from=Slider_Slideshow::getActive()}>
                <div class="slide">
                    <div class="slider-inner">
                        <div>
                            <a class="linkBanner" data="82" href = '<{$slide->url}>'>
                                <img src="<{$me.content}>/slider/slides/<{$slide->image}>" />
                            </a>
                            <div class="text-fon">
                                <p class="sl-title"><{$slide->title}></p>
                                <div class="sl-desc"><{$slide->short}></div>
                            </div>
                            <div class="text-fon-short">
                                <p class="sl-title"></p>
                                 <div class="sl-desc"><a href="<{$slide->url}>" class="linkBanner"></a></div>
                            </div>
                        </div>	
                    </div>
                </div>
             <{/foreach}>
        </div>
    </div>
</div>