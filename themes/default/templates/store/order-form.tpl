<div class="bl-fix-height--wrapper">
    <div class="bl-form--header">
        <div class="column-left">
            Данные получателя
        </div>
        <div class="column-right">
            Адрес доставки
        </div>
    </div>
    <div class="bl-form-field">
        <form class="contact-info-form">
            <div class="column-left" data-title="Данные получателя">
                <div class="row-field">
                    <label for="u_family">Фамилия*</label>
                    <input <{if isset(D::$session['errorFilled']) && in_array('u_family', D::$session['errorFilled'])}>class="error"<{/if}>
                        onkeypress="return filter_input(event,/[А-Я]/i)" 
                        type="text" 
                        name="u_family" 
                        id="u_family" 
                        value="<{if isset(D::$session['formFilled'])}><{D::$session['formFilled']['u_family']}><{/if}>">
                </div>
                <div class="row-field">
                    <label for="u_name">Имя*</label>
                    <input <{if isset(D::$session['errorFilled']) && in_array('u_name', D::$session['errorFilled'])}>class="error"<{/if}>
                        onkeypress="return filter_input(event,/[А-Я]/i)" 
                        type="text" 
                        name="u_name" 
                        id="u_name" 
                        value="<{if isset(D::$session['formFilled'])}><{D::$session['formFilled']['u_name']}><{/if}>">
                </div>
                <div class="row-field">
                    <label for="u_otch">Отчество*</label>
                    <input <{if isset(D::$session['errorFilled']) && in_array('u_otch', D::$session['errorFilled'])}>class="error"<{/if}>
                        onkeypress="return filter_input(event,/[А-Я]/i)" 
                        type="text" 
                        name="u_otch" 
                        id="u_otch" 
                        value="<{if isset(D::$session['formFilled'])}><{D::$session['formFilled']['u_otch']}><{/if}>">
                </div>
                <div class="row-field">
                    <label for="u_tel">Телефон*</label>
                    <input <{if isset(D::$session['errorFilled']) && in_array('u_tel', D::$session['errorFilled'])}>class="error"<{/if}>
                        type="tel" 
                        name="u_tel" 
                        id="u_tel" 
                        onblur="return Order.enterPhone(this)" 
                        value="<{if isset(D::$session['formFilled'])}><{D::$session['formFilled']['u_tel']}><{/if}>">
                </div>
                <div class="row-field">
                    <label for="u_mail">E-mail*</label>
                    <input <{if isset(D::$session['errorFilled']) && in_array('u_mail', D::$session['errorFilled'])}>class="error"<{/if}>
                        type="email" 
                        name="u_mail" 
                        id="u_mail" 
                        value="<{if isset(D::$session['formFilled'])}><{D::$session['formFilled']['u_mail']}><{/if}>">
                </div>
                <div class="row-field">
                    <label for="note">Комментарий</label>
                    <textarea name="u_note" id="u_note"><{if isset(D::$session['formFilled'])}><{D::$session['formFilled']['u_note']}><{/if}></textarea>
                </div>
            </div>
            <div class="column-right" data-title="Адрес доставки">
                <div class="row-field">
                    <label for="u_region">Область*</label>
                    <input <{if isset(D::$session['errorFilled']) && in_array('u_region', D::$session['errorFilled'])}>class="error"<{/if}> 
                        type="text" 
                        name="u_region" 
                        id="u_region" 
                        value="<{if isset(D::$session['formFilled'])}><{D::$session['formFilled']['u_region']}><{/if}>" 
                        autocomplete="off" 
                        data-kladr-type="region">
                                    </div>
                <div class="row-field">
                    <label for="u_zip">Индекс*</label>
                    <input <{if isset(D::$session['errorFilled']) && in_array('u_region', D::$session['errorFilled'])}>class="error"<{/if}>
                        name="u_zip" 
                        onkeypress="return filter_input(event,/[0-9\-]/i)" 
                        type="text" 
                        id="u_zip" 
                        value="<{if isset(D::$session['formFilled'])}><{D::$session['formFilled']['u_zip']}><{/if}>">
                </div>
                <div class="row-field">
                    <label for="u_city">Город*</label>
                    <input <{if isset(D::$session['errorFilled']) && in_array('u_city', D::$session['errorFilled'])}>class="error"<{/if}>
                        type="text" 
                        name="u_city" 
                        id="u_city" 
                        value="<{if isset(D::$session['formFilled'])}><{D::$session['formFilled']['u_city']}><{/if}>" 
                        autocomplete="off" 
                        data-kladr-type="city">
                    <input type="hidden" name="u_area" id="u_area" value="">
                    <!--<span class="error-text">Проверьте написание города</span>-->
                </div>
                <div class="row-field">
                    <label for="u_street">Улица*</label>
                    <input <{if isset(D::$session['errorFilled']) && in_array('u_street', D::$session['errorFilled'])}>class="error"<{/if}>
                        type="text" 
                        name="u_street" 
                        id="u_street" 
                        value="<{if isset(D::$session['formFilled'])}><{D::$session['formFilled']['u_street']}><{/if}>" 
                        autocomplete="off" 
                        data-kladr-type="street">
                </div>
                <div class="row-field-several">
                    <label for="u_home">Дом*</label>
                    <input <{if isset(D::$session['errorFilled']) && in_array('u_home', D::$session['errorFilled'])}>class="error"<{/if}>
                        onkeypress="return filter_input(event,/[0-9а-я\-]/i)" 
                        type="text" 
                        name="u_home" 
                        id="u_home" 
                        value="<{if isset(D::$session['formFilled'])}><{D::$session['formFilled']['u_home']}><{/if}>" 
                        autocomplete="off" 
                        data-kladr-type="building">
                    <label for="u_korpus">Корп.</label>
                    <input <{if isset(D::$session['errorFilled']) && in_array('u_korpus', D::$session['errorFilled'])}>class="error"<{/if}>
                        onkeypress="return filter_input(event,/[0-9а-я\-]/i)" 
                        type="text" 
                        name="u_korpus" 
                        id="u_korpus" 
                        value="<{if isset(D::$session['formFilled'])}><{D::$session['formFilled']['u_korpus']}><{/if}>">
                    <label for="u_room">Кв.*</label>
                    <input <{if isset(D::$session['errorFilled']) && in_array('u_room', D::$session['errorFilled'])}>class="error"<{/if}>
                        onkeypress="return filter_input(event,/[0-9а-я\/\-]/i)" 
                        type="text" 
                        name="u_room" 
                        id="u_room" 
                        value="<{if isset(D::$session['formFilled'])}><{D::$session['formFilled']['u_room']}><{/if}>">
                </div>
                <input type="hidden" name="u_pref_region" id="u_pref_region" value="республика">
                <input type="hidden" name="u_pref_district" id="u_pref_district" value="район">
                <input type="hidden" name="u_pref_city" id="u_pref_city" value="г.">
            </div>
        </form>
    </div>
    <div class="bl-detail-bottom">
        <div class="bl-detail-order-wrapper clearfix">
            <div class="bl-orient--right mr-68">
                <div class="head-text">Мой заказ</div>
                <div class="order-info">
                    <div class="line ">
                        <span class="label">Стоимость товаров:</span>
                        <span class="value"><{$cart_total.total_cost}> руб.</span>
                    </div>		
                    <div class="line ">
                        <span class="label">Скидка:</span>
                        <span class="value">0 руб.</span>
                    </div>		
                    <div class="line strong">
                        <span class="label">Итого стоимость товаров:</span>
                        <span class="value"><{$cart_total.total_cost}> руб.</span>
                    </div>		
                </div>
            </div>
        </div>
        <div class="bl-nav-bnt--wrapper clearfix">
            <div class="left-btn">
                <a href="javascript: window.history.back();">Назад</a>
            </div>
            <div class="right-btn">
                <a href="#" onclick="return Order.step(2)">Далее</a>
            </div>
        </div>
    </div>
</div>
<div class="bl-bottom-note--wrapper">
    <p>*Нажав на кнопку "Далее", Вы предоставляете согласие на обработку и использование персональных данных в соответствии с <a href="/static/privacy" target="_blank">политикой конфиденциальности</a></p>
</div>