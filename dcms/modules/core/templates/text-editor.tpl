<script type="text/javascript" src="<{$config.jscripts_path}>/plugins/jquery-fieldselection.js"></script>
<script >
var tEditor = new function() {
	this.editor = false;
	this.addText = function(text) {
		if(this.editor != false) {
			$(this.editor).replaceSelection(text);
		}
		return false;
	};

	this.insertHyperLink = function() {
		urladdress = prompt('#ENTER_FULL_URL#:','http://');
		if(urladdress == null) {
			return false;
		}
		urlname = prompt('#ENTER_VISIBLE_URL_NAME#:', 'my url');
		if(urlname == null) {
			return false;
		}
		this.addText('[url=' + urladdress + ']' + urlname + '[/url]');
		return false;
	};

	this.insertImage = function() {
		imgurl = prompt('#ENTER_IMAGE_URL#:','http://');
		if(imgurl != null ) {
			this.addText('[img]' + imgurl + '[/img]');
		}
		return false;
	};

	this.insertYoutube = function() {
		youtubeurl = prompt('#ENTER_YOUTUBE_ADDRESS#:','');
		if(youtubeurl != null) {
			this.addText('[youtube]' + youtubeurl + '[/youtube]');
		}
		return false;
	};

	this.quoteText = function() {
		inputSelection = $(this.editor).getSelection().text;
		windowSelection = this.getSelectedText();
		if(inputSelection.length > 0 || windowSelection.length == 0 ) {
			this.addTagged('quote');
		} else {
			this.addText('[quote]' + windowSelection + '[/quote]');
		}
		return false;
	};

	this.addTagged = function(tag) {
		if(this.editor != false) {
			$(this.editor).replaceSelection('[' + tag + ']' + $(this.editor).getSelection().text + '[/' + tag + ']');
		}
		return false;
	}

	this.getSelectedText = function() {
    	var txt = '';
    	if (window.getSelection) {
			txt = window.getSelection();
	    } else if (document.getSelection) {
			txt = document.getSelection();
		} else if (document.selection) {
			txt = document.selection.createRange().text;
		} else return;
		return txt;
	};
	this.setActiveEditor = function(editor) {
		this.editor = editor;
	};
};
$(document).ready(function(){
	$('.textinput_area').bind('focus', function() {
		tEditor.setActiveEditor(this);
	});
});
</script>
<table class="message_editor">
 <tr>
  <td class="msg_smiles">
   <{foreach item=smile key=code from=D_Misc_Text::getSmilesList()}>
    <img onclick="return tEditor.addText('<{$code}>');" src="<{$theme.images}>/smiles/<{$smile}>">
   <{/foreach}>
  </td>
 </tr>
 <tr>
  <td class="cm_tools">
     <button class='cms_teditor_b' onclick='return tEditor.addTagged("b");'><b>B</b></button>
     <button class='cms_teditor_i' onclick='return tEditor.addTagged("i");'><i>i</i></button>
     <button class='cms_teditor_u' onclick='return tEditor.addTagged("u");'><u>U</u></button>
     <button class='cms_teditor_a' onclick='return tEditor.insertHyperLink();'><img src="<{$theme.images}>/editor/url.gif">URL</button>&nbsp;
     <button class='cms_teditor_img' onclick='return tEditor.insertImage();'><img src="<{$theme.images}>/editor/picture.gif">&nbsp;IMG</button>
     <button onclick='return tEditor.insertYoutube();'><img src="<{$theme.images}>/editor/youtube.gif">&nbsp;YouTube</button>
     <button onclick='return tEditor.quoteText();'><img src="<{$theme.images}>/editor/quote.gif">&nbsp;Quote</button>
     <button onclick='return tEditor.addTagged("hidden");'>Hidden</button>
   </td>
 </tr>
 <tr>
   <td><textarea id="textInput" class="cm_textarea textinput_area" name="<{if isset($name)}><{$name}><{else}>content<{/if}>" rows="6"><{$content}></textarea>
   </td>
  </tr>
</table>