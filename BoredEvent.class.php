<?php

class BoredEvent extends BoredBase {

	public function search($search) {
		if (!empty($search->pid)) {

			$interests = (isset($search->interests) && !empty($search->interests)) ? implode("','",$search->interests) : false;
			$radius = (isset($search->radius) && !empty($search->radius)) ? $search->radius : false;
			$start = (isset($search->start) && !empty($search->start)) ? date("Y-m-d H:i:00",strtotime($search->start)) : false;
			$end = (isset($search->end) && !empty($search->end)) ? date("Y-m-d H:i:59",strtotime($search->end)) : false;
			$city = (isset($search->city) && !empty($search->city)) ? $search->city : false;

			$q = "
				SELECT
			";
			if (isset($search->count)) {
				$q .= "count(e.id) as eventsCount";
			} else {
				$q .= "
					e.id as eid,
					e.type,
					e.radius,
					e.start,
					e.end,
					e.title,
					e.description,
					e.location,
					e.pid,
					e.city,
					p.name as pname,
					p.phone as pphone,
					p.email as pemail
				";
			}
			$q .= "
				FROM
					events e
				LEFT JOIN
					persons p
				ON
					e.pid = p.id
				WHERE
					e.end > NOW()
			";
			$q .= ($radius !== false) ? " AND e.radius >= ".intval($radius) : "";
			$q .= ($interests !== false) ? " AND e.type IN ('".$interests."')" : "";
			$q .= ($start !== false) ? " AND e.start >= '".$start."'" : "";
			$q .= ($end !== false) ? " AND e.end <= '".$end."'" : "";
			$q .= ($city !== false) ? " AND e.city = '".$city."'" : "";
//			$q .= ($location !== false) ? " AND e.location = '".$location."'" : "";

			$r = DB::read($q);
			if (isset($search->count)) {
				return $r[0];
			}
			return $r;
		}
		return $this->error('BORED_PERSON_NEEDED');
	}

	public function get($eid) {
		$q = "
			SELECT
				e.id as eid,
				e.type,
				e.radius,
				e.start,
				e.end,
				e.title,
				e.desctiption,
				e.location,
				e.pid,
				e.city,
				p.name as pname,
				p.phone as pphone,
				p.email as pemail
			FROM
				events e
			LEFT JOIN
				persons p
			ON
				e.pid = p.id
			WHERE
				e.id = '".intvla($eid)."'
		";
		$r = DB::read($q);
		if (!empty($r)) {
			return $r[0];
		}
		return $this->error('BORED_EVENT_MISSING');
	}

	public function register($event) {
		if (!isset($event->type)) {
			return $this->error('BORED_EVENT_NEEDS_TYPE');
		}
		if (!isset($event->radius)) {
			return $this->error('BORED_EVENT_NEEDS_RADIUS');
		}
		if (!isset($event->start)) {
			return $this->error('BORED_EVENT_NEEDS_START');
		}
		if (!isset($event->end)) {
			return $this->error('BORED_EVENT_NEEDS_END');
		}
		if (!isset($event->pid)) {
			return $this->error('BORED_EVENT_NEEDS_PERSON');
		}
		if (!isset($event->title)) {
			return $this->error('BORED_EVENT_NEEDS_TITLE');
		}
		if (!isset($event->description)) {
			return $this->error('BORED_EVENT_NEEDS_DESCRIPTION');
		}
		if (!isset($event->location)) {
			return $this->error('BORED_EVENT_NEEDS_LOCATION');
		}

		$q = "
			INSERT INTO	events (
				type,
				radius,
				start,
				end,
				pid,
				title,
				description,
				location,
				city
			) VALUES (
				'".DB::escape($event->type)."',
				'".DB::escape($event->radius)."',
				'".DB::escape($event->start)."',
				'".DB::escape($event->end)."',
				'".intval($event->pid)."',
				'".DB::escape($event->title)."',
				'".DB::escape($event->description)."',
				'".DB::escape($event->location)."',
				'Sofia'
			)
		";

		if (false !== DB::write($q)) {
			$event->eid = DB::lastid();
		}

		return $event;
	}

}
