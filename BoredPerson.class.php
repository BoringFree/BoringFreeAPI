<?php

class BoredPerson extends BoredBase {

	public function get($person) {
		if (!empty($person->pid)) {
			$bf = new BoredFile();
			$bf->id = $person->pid;
			$bf->isPerson();
			if (false !== ($person = $bf->read())) {
				return $person;
			}
		}
		return $this->error('BORED_PERSON_NOT_EXIST');
	}

	public function register($person) {
		if (empty($person->pid)) {
			if (empty($person->name)) {
				return $this->error('BORED_PERSON_NO_NAME_PROVIDED');
			}
			if (empty($person->pass)) {
				return $this->error('BORED_PERSON_NO_PASS_PROVIDED');
			}

			// store pass as md5;
			$person->pass = md5($person->pass);

			if (!isset($person->interests)) {
				$person->interests = array();
			}
			if (!isset($person->phone)) {
				$person->phone = '';
			}
			if (!isset($person->email)) {
				$person->email = '';
			}
			if (!$this->isPersonRegistered($person->name)) {
				$person->pid = Bored::getUnique();
				$bf = new BoredFile();
				$bf->id = $person->pid;
				$bf->isPerson();
				$bf->write($person);

				// ugly hack
				unset($person->pass);

				return $person;
			}
		}
		return $this->error('BORED_PERSON_EXISTS');
	}


	public function isPersonRegistered($name) {
		$bf = new BoredFile();
		$bf->isPerson();
		$eval = new stdClass();
		$eval->name = $name;
		$a = $bf->evalAll($eval, false);
		if (false !== $a) {
			return true;
		}
		return false;
	}

	public function login($person) {

		if (empty($person->name)) {
			return $this->error('BORED_PERSON_NO_NAME_PROVIDED');
		}

		if (empty($person->pass)) {
			return $this->error('BORED_PERSON_NO_PASS_PROVIDED');
		}

		// stored pass as md5;
		$person->pass = md5($person->pass);

		$bf = new BoredFile();
		$bf->isPerson();

		if (false !== ($person = $bf->evalAll($person))) {

			// ugly hack
			unset($person->pass);

			return $person;

		}
		return $this->error('BORED_PERSON_NOT_EXIST');

	}

}