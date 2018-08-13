<?php
class Core_I18n_SpeakLike extends D_Core_Object {
	public $username = false;
	public $password = false;

	public $url =  'http://api.speaklike.com/REST/controller/send';

	static private $instance = false;

	public function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
	}

	protected function getAuthCmd() {
		return '<cmd type="Login" id="'.uniqid().'"><u>'.$this->username.'</u><p>'.$this->password.'</p></cmd>';
	}

	public function auth() {
		$req = '<SLClientMsg><responseFormat>xml</responseFormat>'.$this->getAuthCmd().'</SLClientMsg>';

		//var_dump($req);exit;
		return D_Misc_Url::FetchDocument($this->url, $req);
		//var_dump($data);
	}

	function getTranslationDocument($message, $from = 'en', $to = 'es') {
		//return '';
		return '<cmd type="SubmitDocument" id="'.uniqid().'">
		<document>
			<originalLangId>'.$from.'</originalLangId>
			<targetLanguages>
				<langId>'.$to.'</langId>
			</targetLanguages>
			<name>speaklike_translation</name>
			<mimeType>text/plain</mimeType>
			<encoding>none</encoding>
			<contents><![CDATA['.$message.']]></contents>
		</document>
		<allowDuplicates>false</allowDuplicates>
		<serviceLevel>4hour-basic</serviceLevel>
		<callback type="translationComplete" method="FORM">
				<url>'.D::$web.'/core/speaklike-callback/</url>
				<formParams>
					<param name="sourceLang" val="%SPEAKLIKE_SOURCE_LANG_ID%"/>
					<param name="targetLang" val="%SPEAKLIKE_TARGET_LANG_IDS%"/>
					<param name="sourceText" val="%SPEAKLIKE_ORIGINAL_CONTENTS%"/>
					<param name="targetText" val="%SPEAKLIKE_TRANSLATED_CONTENTS_'.$to.'%"/>
				</formParams>
				<expectedResponse>OK</expectedResponse>
		</callback>
</cmd>';
		/**
		return '<cmd type="SubmitDocument" id="'.uniqid().'"><document><originalLangId>'.$from.'</originalLangId><targetLanguages><langId>'.$to.'</langId></targetLanguages>
		<name>speaklike_translation</name>
		<mimeType>text/plain</mimeType>
		<encoding>none</encoding>
		<contents>'.$message.'</contents>
		</document>
		<allowDuplicates>false</allowDuplicates>
			<serviceLevel>4hour-basic</serviceLevel>
			<notifications>
				<notification type="TRANSLATION_COMPLETE" enabled="true" />
				<notification type="EXPIRED" enabled="true" />
				<notification type="OUT_OF_CREDITS" enabled="true" />
			</notifications>
			<callback type="translationComplete" method="FORM">
				<url>'.D::$web.'/core/speaklike-callback/</url>
				<formParams>
					<param name="sourceLang" val="%SPEAKLIKE_SOURCE_LANG_ID%"/>
					<param name="targetLang" val="%SPEAKLIKE_TARGET_LANG_IDS%"/>
					<param name="sourceText" val="%SPEAKLIKE_ORIGINAL_CONTENTS%"/>
					<param name="targetText" val="%SPEAKLIKE_TRANSLATED_CONTENTS_'.$to.'%"/>
				</formParams>
				<expectedResponse>OK</expectedResponse>
			</callback>
		</cmd>';*/

	}

	public function translate($message, $from = 'en', $to = 'es') {
		$message = "Our servers are located in many countries around the world, allowing you to access almost any resources to which access has earlier been closed.";
		//$message = 'Hello';

		$req = '<SLClientMsg><responseFormat>xml</responseFormat>'.$this->getAuthCmd().$this->getTranslationDocument($message, $from, $to).'</SLClientMsg>';

		return D_Misc_Url::FetchDocument($this->url, $req);
		//echo $req;
	}

	static public function getInstance() {
		if(self::$instance) return self::$instance;

		self::$instance = new self(D::$config->{'core.i18n.speaklike.username'}, D::$config->{'core.i18n.speaklike.password'});
		return self::$instance;
	}
}