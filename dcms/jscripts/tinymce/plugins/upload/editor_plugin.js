(function() {

	tinymce.create('tinymce.plugins.upload', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
			ed.addCommand('upload', function() {
				
				var form = $("<form>").attr("id","tinymce_form").attr("enctype","multipart/form-data").attr("method","post")
							.attr("action","/admin/run/filemanager/tinymce-upload").submit(function() { 
								var options = { onComplete: function (result) {
										var image = $(result).find('upload').text();
										tinymce.activeEditor.selection.setContent("<img src='"+image+"'>");
									}
								};
								ajax_upload_form.upload(this,options); 
							});
				var file = $("<input>").attr("type","file").attr("name","upload_file").attr("id","tinymce_upload_file");
				
				$(form).append(file);
				$("body").append(form);
				
				$("#tinymce_upload_file").change(function () { 
					
					$("#tinymce_form").submit();
					$("#tinymce_form").remove();
				});
				
				$(file).click();
								
			});

			// Register example button
			ed.addButton('upload', {
				title : 'upload.desc',
				cmd : 'upload',
				image : url + '/img/button.gif'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('upload', n.nodeName == 'IMG');
			});
		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'jabber://nortel@dinix.ru',
				author : 'Alexander Alexander',
				authorurl : 'http://localhost',
				infourl : 'http://localhost',
				version : "1.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('upload', tinymce.plugins.upload);
})();
