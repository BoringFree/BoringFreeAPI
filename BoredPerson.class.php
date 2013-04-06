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
			$person->pid = Bored::getUnique();
			$bf = new BoredFile();
			$bf->id = $person->pid;
			$bf->isPerson();
			$bf->write($person);
			return $person;
		}
		return $this->error('BORED_PERSON_EXISTS');
	}

	public function login($person) {

		if (empty($person->name)) {
			return $this->error('BORED_PERSON_NO_NAME_PROVIDED');
		}

		if (empty($person->pass)) {
			return $this->error('BORED_PERSON_NO_PASS_PROVIDED');
		}

		$bf = new BoredFile();
		$bf->isPerson();

		if (false !== ($person = $bf->evalAll($person))) {
			return $person;
		}
		return $this->error('BORED_PERSON_NOT_EXIST');

	}

}