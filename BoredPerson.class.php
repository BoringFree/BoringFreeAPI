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
					id as pid,
					name,
					phone,
					photo,
					email,
					interests
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

			error_log($q);

			$r = DB::read($q);
			if (isset($search->count)) {
				return $r[0];
			}
			foreach ($r as $k=>$v) {
				$r[$k]->interests = explode(',', $v->interests);
			}
			error_log(print_r($r,1));
			return $r;

		}
		return $this->error('BORED_PERSON_NEEDED');
	}

	public function iambored($person) {
		if (!empty($person->pid)) {
			$p = array();
			if (isset($person->interests)) {
				foreach ($person->interests as $v) {
					if (isset(BoredBase::$interests[$v])) {
						$p[] = $v;
					}
				}
			}
			$person->interests = $p;
			$q = "UPDATE persons SET interests = '".DB::escape(implode(',',$person->interests))."' WHERE id = ".intval($person->pid);
			DB::write($q);
			return $this->get($person);
		}
		return $this->error('BORED_PERSON_NEEDED');
	}

	public function get($person) {
		if (!empty($person->pid)) {

			$q = "
				SELECT
					id as pid,
					name,
					phone,
					photo,
					email,
					interests
				FROM
					persons
				WHERE
					id = ".intval($person->pid);
			$r = DB::read($q);
			if (!empty($r)) {
				$r = $r[0];
				$r->interests = explode(',', $r->interests);
				return $r;
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