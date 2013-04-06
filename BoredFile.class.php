<?php

define ('BF_TYPE_PERSON','person');
define ('BF_TYPE_EVENT','event');
define ('BF_TYPE_MSG','message');
define ('BF_TYPE_LOC','location');
define ('BF_EXT','.json');

class BoredFile {

	public $id;
	public $type;

	protected $file;

	// function to set Object Type

	public function isPerson() {
		$this->type = BF_TYPE_PERSON;
	}

	public function isEvent() {
		$this->type = BF_TYPE_EVENT;
	}

	public function isMsg() {
		$this->type = BF_TYPE_MSG;
	}

	// data functions

	public function read() {
		if (!$this->checkFile()) {
			return false;
		}
		$r = json_decode(@file_get_contents($this->evalFile()));
		if (!is_object($r)) {
			return false;
		}
		return $r;
	}

	public function write($data) {
		if ($this->checkFile()) {
			if (@file_put_contents($this->evalFile(), json_encode($data))) {
				return true;
			}
		}
		return false;
	}

	protected function evalFile() {
		return BORED_ROOT . '/' . $this->type . '/' . $this->id . BF_EXT;
	}

	protected function checkFile() {
		if (empty($this->id) || empty($this->type)) {
			return false;
		}
		return true;
	}

	public function getAll() {
		if (empty($this->type)) {
			return false;
		}
		$all = scandir(BORED_ROOT . '/' . $this->type . '/');
		$r = array();
		foreach ($all as $v) {
			if (substr_compare($v,'.json',-1,5,true)) {
				$r[] = $v;
			}
		}
		return $r;
	}

	public function evalAll($eval, $read = true) {
		if (empty($this->type)) {
			return false;
		}
		$all = scandir(BORED_ROOT . '/' . $this->type . '/');
		$r = array();
		foreach ($all as $v) {
			$id = substr($v,0,-5);
			$origin = json_decode(@file_get_contents(BORED_ROOT . '/' . $this->type . '/'.$v));
			foreach ($eval as $k=>$v) {
				if (!isset($origin->$k) || $origin->$k != $v) {
					continue;
				}
				if ($read) {
					$this->id = $id;
					return $this->read();
				}
				return $id;
			}
		}
		return false;
	}

}
