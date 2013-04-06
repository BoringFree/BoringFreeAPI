<?php

class BoredPerson extends BoredBase {

	public function search($search) {
		if (!empty($search->pid)) {

			$interests = (isset($search->interests) && !empty($search->interests)) ? $search->interests : false;

			$q = "
				SELECT
			";
			if (isset($search->count)) {
				$q .= "count(id) as personsCount";
			} else {
				$q .= "
					*
				";
			}
			$q .= "
				FROM
					persons
			";
			if ($interests) {
				$q .= "
					WHERE
						1=0
				";
				foreach ($interests as $v) {
					$q.= " OR FIND_IN_SET('".DB::escape($v)."',interests) > 0 ";
				}
			}

			$r = DB::read($q);
			if (isset($search->count)) {
				return $r[0];
			}
			return $r;

		}
		return $this->error('BORED_PERSON_NEEDED');
	}

	public function get($person) {
		if (!empty($person->pid)) {

			$q = "SELECT * FROM persons WHERE id = ".intval($person->pid);
			$r = DB::read($q);
			if (!empty($r)) {
				return $r[0];
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

				$q = "
					INSERT INTO persons (
						name,
						pass,
						interests,
						phone,
						email
					) VALUES (
						'".DB::escape($person->name)."',
						MD5('".DB::escape($person->pass)."'),
						'".DB::escape(implode(',',$person->interests))."',
						'".DB::escape($person->phone)."',
						'".DB::escape($person->email)."'
					)
				";

				if (false !== DB::write($q)) {
					$person->pid = DB::lastid();
				}

				// ugly hack
				unset($person->pass);

				return $person;

			}
		}
		return $this->error('BORED_PERSON_EXISTS');
	}


	public function isPersonRegistered($name) {
		$q = "
			SELECT count(id) as cnt FROM persons WHERE name = '".DB::escape($name)."'
		";
		$r = DB::read($q);
		if ($r[0]->cnt > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function login($person) {

		if (empty($person->name)) {
			return $this->error('BORED_PERSON_NO_NAME_PROVIDED');
		}

		if (empty($person->pass)) {
			return $this->error('BORED_PERSON_NO_PASS_PROVIDED');
		}

		$q = "
			SELECT
				id as pid,
				name,
				pass,
				interests,
				phone,
				email
			FROM
				persons
			WHERE
				name = '".DB::escape($person->name)."'
			AND
				pass = MD5('".$person->pass."')
		";

		$r = DB::read($q);

		if (!empty($r)) {
			$person = $r[0];
			$person->interests = explode(',',$person->interests);
			// ugly hack
			unset($person->pass);
			return $person;

		}
		return $this->error('BORED_PERSON_NOT_EXIST');

	}

}