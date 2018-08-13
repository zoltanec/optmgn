<?php
trait Core_I18n_Localizeable {
	function localize($field) {
		if(D::$req->lang == D::$config->default_language) return $this->{$field};

		return D::$i18n->getTranslation(strtoupper(md5($this->object_id().$field)));
	}
}