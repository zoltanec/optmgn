<?php
/**
 * Allow sites to communicate with CLI daemon via database
 */
class Core_Ipc_Stream {
	private $stream = '';

	public function __construct($stream) {
		$this->stream = $stream;
	}

	/**
	 * Read one IPC message from stream
	 */
	public function readone() {
		$msg = Core_Ipc_Messages::find(['stream' => md5($this->stream)], ['limit' => 1, 'order' => 'msgid']);
		if(empty($msg)) {
			return false;
		}
		$msg->delete();
		return $msg->instance;
	}

	/**
	 * Read all messages from IPC
	 */
	public function readall() {
		$msgs = Core_Ipc_Messages::find(['stream' => md5($this->stream)], ['order' => 'msgid ASC']);
		$parsed = [];

		foreach($msgs AS $msg) {
			$parsed[] = $msg->instance;
			$msg->delete();
		}

		return $parsed;
	}

	/**
	 * Send object to IPC stream. Object will be converted to JSON format and encoded in base64
	 *
	 *  mix $instance - object to send
	 *
	 */
	public function send($instance = "") {
		$msg = new Core_Ipc_Messages();
		$msg->stream = md5($this->stream);
		$msg->msg = base64_encode(json_encode($instance));
		$msg->save();
		return true;
	}
}
?>