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
		'events' => array('BoredEvent','search'),
		'eventsRegister' => array('BoredEvent','register'),
		'getnotifications'
	);

	public function init() {
//		$p = file_get_contents('php://input');
//		error_log($p);
		error_log(print_r($_GET,1));
//		error_log(print_r($_REQUEST,1));
//		echo "test";
//		die();
//		$p = file_get_contents('php://input');
		$p = $_GET;
		$_SESSION['callback'] = $p['callback'];
		unset($p["_"]);
		unset($p["callback"]);
		$this->payload = json_decode(json_encode($p), FALSE);
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
		$r = $_SESSION['callback'] . "(".json_encode($data).")";
		die($r);
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
		if (!isset($this->payload->params)) {
			$this->payload->params = null;
		}
		$result = $o->$m($this->payload->params);
		$this->write($result);
	}

}
