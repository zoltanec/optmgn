function D(settings) {
	if(typeof settings == 'string') {
		var module = settings;
		if(module in D.modules) {
			return D.modules[module];
		}
	}
	var self = this;
	
	if(settings.context != undefined) {
		self.context = settings.context;
	} else {
		self.context = 'user';
	}
	self.modules = {};
	
	if(settings.www != undefined) {
		self.www = settings.www;
	} else {
		throw "No WWW adress defined";
	}
	if(settings.theme_images != undefined) {
		self.theme_images = settings.theme_images;
	} else {
		self.theme_images = settings.www + '/theme/default/images';
	}
	if(settings.content != undefined) {
		self.content = settings.content;
	} else {
		self.content = settings.www + '/content';
	}
	
	self.init = function(settings) {
		
	};
	
	self.get_context = function() {
		return self.context;
	};
	
	self.ajax = new function() {
		var ajax = this;
		this.req = function(request_url,options) {
			var ajax_options = new function() {
				if(options.data != undefined) {
					this.type = 'POST';
					this.data = options.data;
				} else {
					this.type = 'GET';
				}
				this.url = request_url;
				this.success = function(answer){
					if(options.mode == 'txt') {
						//ajax.parse_answer(answer);
					}
					if(typeof options.success == 'function') {
						options.success(answer);
					};
				};
			};
			var xhr = $.ajax(ajax_options);
		};
		this.parse_answer = function(answer) {
			if(answer.substr(0,6) == 'ERROR_') {
				var error_code = answer.substr(6);
			} else {
				
			}
		};
	};
	
	self.time = function() {
		var time = new Date().getTime();
		return time;
	};
	
	/**
	 * Sending form over ajax request.
	 */
	
	self.send_form = function (id,callback) {
		
		var data = {};
		
		var form = $('#'+id);
		$(form).find("input").each(function (i) {
			
			if ( $(this).attr("type") == "checkbox" ) {
				data[$(this).attr("name")] = ( $(this).attr("checked") == undefined ? 0 : 1);
			} else if ( $(this).attr("type") == "submit" ) {

			} else {
				data[$(this).attr("name")] = $(this).attr("value");
			}
		});
		
		$(form).find("select").each(function () {
			
			data[$(this).attr("name")] = $(this).attr("value");
		});
		
		$(form).find("textarea").each(function () {
			data[$(this).attr("name")] = $(this).val();
		});
		
		
		$.post( $(form).attr("action"), data, callback);
		
	};
	
	
	/**
	 * Working with cookie 
	 */
	
	self.cookie = function (key, value, options) {
	    // key and at least value given, set cookie...
	    if (arguments.length > 1 && String(value) !== "[object Object]") {
	        options = self.extend({}, options);

	        if (value === null || value === undefined) {
	            options.expires = -1;
	        }

	        if (typeof options.expires === 'number') {
	            var days = options.expires, t = options.expires = new Date();
	            t.setDate(t.getDate() + days);
	        }
	        
	        value = String(value);
	        
	        return (document.cookie = [
	            encodeURIComponent(key), '=',
	            options.raw ? value : encodeURIComponent(value),
	            options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
	            options.path ? '; path=' + options.path : '',
	            options.domain ? '; domain=' + options.domain : '',
	            options.secure ? '; secure' : ''
	        ].join(''));
	    }

	    // key and possibly options given, get cookie...
	    options = value || {};
	    var result, decode = options.raw ? function (s) { return s; } : decodeURIComponent;
	    return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;
	};

	
	self.register = function(modulename, module) {
		D.modules[modulename] = new D.module(module,{'name' : modulename});
	};
	
	self.module = function(module,settings) {
		if(settings.name == undefined) {
			throw "No module name";
		}
		module.request_path = (module.request_path == undefined ) ? self.www + '/' + settings.name : module.request_path;

//		module.request_path = self.www + '/' + settings.name;
		module.request_admin_path = self.www + '/admin/run/' + settings.name;
		
		module.images = self.theme_images + '/' + settings.name;
		module.content = self.content + '/' + settings.name;
		
		/** call needed function and set arguments for AJAX directly */
		module.call = function(action,param1,param2) {
			//var context = (arguments[arguments.length - 1] == 'user' || arguments[arguments.length - 1] == 'admin') ? arguments[arguments.length - 1],
			if(param2 == undefined) {
				param2 = self.context;
			}
			if(param2 == 'user' ) {
				//alert(action.indexOf('/'));
				//if(action.indexOf('/'))
				var url = module.request_path + '/' + action;
			} else {
				var url = module.request_admin_path + '/' + action;
			}
			if(typeof param1 == 'function') {
				var options = { success: param1 };
			} else {
				var options = param1;
			}
			self.ajax.req(url, options);
		};
		/** fast simply call */
		module.run = function() {
			var options = {};
			var action = arguments[0];
			
			// last argument is context
			var context = (arguments[arguments.length - 1] == 'user' || arguments[arguments.length - 1] == 'admin') ? arguments[arguments.length-1] : self.context;
			var url = (context == 'user' ) ? module.request_path + '/' + action : module.request_admin_path + '/' + action;
			if(arguments.length > 1) {
				if(typeof arguments[1] == 'object') {
					options.data = arguments[1];
					if(typeof arguments[2] == 'function') {
						options.success = arguments[2];
					}
					if(typeof arguments[3] == 'function') {
						options.error = arguments[3];
					}
				} else if(typeof arguments[1] == 'function') {
					options.success = arguments[1];
					if(typeof arguments[2] == 'function') {
						options.error = arguments[2];
					}
				} 
			}
			self.ajax.req(url, options);
		};
		
		module.storage = new function() {
			var storage = this;
			
			this.isset = function(name) {
				var value = localStorage.getItem(settings.name + '_' + name);
				if ( value == undefined ) {
					return false;
				}
				return true;
			};
			
			this.get = function(name) {
				return localStorage.getItem(settings.name + '_' + name);
			};
			
			this.set = function(name, value) {
				localStorage.setItem(settings.name + '_' + name, value);
			};
			
			this.have_local_storage = function() {
				try {
					return 'localStorage' in window && window['localStorage'] !== null;
				} catch (e) {
					return false;
				}				
			};
		};
		
		return module;
	};
	self.extend = function(old_settings, need_settings) {
		if(old_settings == undefined) {
			return need_settings;
		}
		for(var i in need_settings) {
			if(old_settings[i] == undefined ) {
				old_settings[i] = need_settings[i];
			}
		}
		return old_settings;
	};
	self.language_messages = false;
	self._ = function(param1) {
		if(self.language_messages == false && typeof param1 == 'object') {
			self.language_messages = param1;
		} else if(typeof param1 == 'object') {
			for(var i in param1) {
				self.language_messages[i] = param1[i];
			}
		} else if(self.language_messages == false) {
			throw "I18n not initialized";
		} else if(param1 in self.language_messages) {
			if(arguments.length > 1 ) {
				var formatted = self.language_messages[param1];
				for (var i = 0; i <= arguments.length; i++) {
					var regexp = new RegExp('\\{'+i+'\\}', 'gi');
				    formatted = formatted.replace(regexp, arguments[i]);
				}
				return formatted;
			} else {
				return self.language_messages[param1];
			}
		} else {
			return param1;
		}
	};
	
	/** UI */
	
	self.ui = new function() {
		var self = this;
		self.popup = function(content, settings) {
			var popup_config = D.extend(settings, {'close_button' : 1, 'classes': ''});
			
			if(popup_config.close_button != undefined ) {
				popup_config.close_button = D.theme_images + '/ui/modal_window_close.png';
			}
			UI.popup(content,popup_config);
		};
	};
	
	/**
	 * This is a list of usable classes for JS programming
	 */
	
	/**
	 * Objects list allows you to keep list of
	 * available objects, find previous and next elements for object.
	 * Use it when you need to implement JavaScript popup windows for each item from big list, 
	 * but don't want to ask server to find prev/next item.
	 *
	 */
	self.ObjectsList = function() {
		var list = this;
		list.elements = new Array();
		
		list.add = function(value) {
			list.elements.push(value);
		};
		
		list.next = function(value) {
			pos = list.elements.indexOf(value);
			if(pos == list.elements.length - 1) {
				return list.elements[0];
			} else {
				return list.elements[pos+1];
			}
		};
		
		list.prev = function(value) {
			pos = list.elements.indexOf(value);
			if(pos == 0) {
				return list.elements[list.elements.length - 1];
			} else {
				return list.elements[pos-1];
			}
		};
	};
	
	
	
	$(document).ready(function(){
		for(var num in self.modules) {
			if('onready' in self.modules[num]) {
				self.modules[num].onready();
			}
		}
	});
};

String.prototype.trim = function () {
    return this.replace(/^\s*/, "").replace(/\s*$/, "");
};


/** Bug fix for internet explorer **/
try {
	var test_array = ['a'];
	test_array.indexOf('a');
} catch (e) {
	Array.prototype.indexOf = function(obj){
        for(var i=0; i<this.length; i++){
            if(this[i]==obj){
                return i;
            }
        }
        return -1;
    };
}
