
<table class="news_sections news_select_section">
 <tr class="logo">
    <{foreach item=section from=News_Sections::getAllSections()}>
    	<{if $section->public}>
        <td data-section-key="<{$section->section_key}>">
            <a href="<{$me.path}>/archive/<{$section->section_key}>/"><img alt="<{$section->section_name}>" src="<{$me.my_content}>/sections/section<{$section->sid}>.png"></a>
        </td>
        <{/if}>
    <{/foreach}>
 </tr>
 <tr class="title">
    <{foreach item=section from=News_Sections::getAllSections()}>
       <{if $section->public}>
        <td data-section-key="<{$section->section_key}>"><a href="<{$me.path}>/archive/<{$section->section_key}>/"><{$section->section_name}></a></td>
       <{/if}>
    <{/foreach}>
 </tr>
</table>