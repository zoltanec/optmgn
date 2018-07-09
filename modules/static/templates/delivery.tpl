<div id="content" class="clearfix">
    <link href="<{$theme.css}>/catalog/order.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="<{$config->jscripts_path}>/theme/catalog/order.js"></script>
    <div class="bl-wrapper-order--main">
        <div class="bl-fix-height--wrapper">
            <div class="bl-wrapper-order--header" style="border-bottom: 1px solid #9e9e9e;">
                <div class="bl-label--header">
                    Доставка
                </div>
            </div>
            <div>
            <div class="bl-form-field">
                <div class="bl-form-title">
                Введите название Вашего населенного пункта
                </div>
                <div class="row-field" id="calc_city_form">
                    <input onkeypress="" type="text" class="payinput" name="u_city" id="calc_city" value="" autocomplete="off" data-kladr-type="city" style="float: left;">
                    <div id="load_image"></div>
                    <input type="hidden" name="u_area" id="calc_area" value="" autocomplete="off" data-kladr-type="area">
                    <input type="hidden" name="u_region" id="calc_region" value="" autocomplete="off" data-kladr-type="region">
                    <input type="hidden" name="u_pref_region" id="pref_region" value="" autocomplete="off">
                    <input type="hidden" name="u_pref_district" id="pref_district" value="" autocomplete="off">
                    <input type="hidden" name="u_pref_city" id="pref_city" value="" autocomplete="off">
                    <div class="clear"></div>
                    <br><span style="color: red; display: none;" id="calc_city_error">Пожалуйста, проверьте написание</span>
                </div>
            </div>
            <div id="result_calc"></div>
        </div>
    </div>
</div>