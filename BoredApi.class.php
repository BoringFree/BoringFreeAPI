<?php

if (!defined('APP')) {die();}

// api handler of requests
class BoredApi {

	public $payload = '';

	public $commands = array(
		'login' => array('BoredPerson','login'),
		'register' => array('BoredPerson','register'),
		'dashboard',
		'iambored',
		'events',
		'getnotifications'
	);

	public function init() {
		$this->payload = json_decode(file_get_contents('php://input'));
		$this->read();
		$this->process();
	}

	public function read() {
		if (!is_object($this->payload)) {
			$this->error('API_ERROR_NO_PAYLOAD');
		}
		if (!isset($this->payload->appkey) || BORED_KEY != $this->payload->appkey) {
			$this->error('API_ERROR_BAD_KEY');
		}
		if (!isset($this->payload->cmd) || !key_exists($this->payload->cmd,$this->commands)) {
			$this->error('API_ERROR_BAD_COMMAND');
		}

	}

	public function write($data) {
		die(json_encode($data));
	}

	public function error($error) {
		$this->write(array(
			'error' => $error
		));
	}

	public function process() {
		$c = $this->commands[$this->payload->cmd][0];
		$m = $this->commands[$this->payload->cmd][1];
		$o = new $c;
		$result = $o->$m($this->payload->params);
		$this->write($result);
	}

}
