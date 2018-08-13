<h2>Глобальные настройки</h2>

<table class="cms_core_settings_list">
<{foreach item=setting from=Settings::getGlobalSettingsList()}>
 <tbody class="cms_core_setting" data-setting-id="<{$setting->setting_id}>" data-type="<{$setting->setting_type}>">
  <tr>
   <td colspan="2">Код:<{$setting->setting_id}></td>
  </tr>
  <tr>
   <td>
   	<span class="cms_core_setting_name"><{_ code=$setting->lng}>:</span>
   	<div class="cms_core_settings_descr"><{_ code=$setting->lng_descr}></div>
   </td>
   <td>
   <{assign var=value value=SettingValue::val($setting->setting_id)}>
   <{if $setting->type == 'int' || $setting->type == 'string' || $setting->type == 'float'}>
   	<input type="text" name="value" value="<{SettingValue::val($setting->setting_id)}>">
   <{elseif $setting->type 	== 'bool'}>
   	<input type="checkbox" name="value"<{if $value}> checked<{/if}>>
   <{/if}>
   </td>
  </tr>
  <tr>
   <td>
   <span class="cms_core_settings_saved"></span>
   <input type="submit" class="submit_update" value="#SAVE#"></td>
  </tr>
 </tbody>
<{/foreach}>
</table>

<script type='text/javascript'>
D.modules.core.bind_view_settings_page();
</script>