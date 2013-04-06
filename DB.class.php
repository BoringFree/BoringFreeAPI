<?php

class DB {

	public static $db;

	public static function connect() {
		self::$db = new mysqli(BORED_DBHOST, BORED_DBUSER, BORED_DBPASS, BORED_DBNAME);
		self::$db->query("SET NAMES UTF8");
	}

	public static function read($q , $obj = true) {
		$r = array();
		$res = self::$db->query($q);
		if (0 < $res->num_rows) {
			if ($obj) {
				while ($row = $res->fetch_object()) {
					$r[] = $row;
				}
			} else {
				while ($row = $res->fetch_assoc()) {
					$r[] = $row;
				}
			}
		}
		$res->close();
		return $r;
	}

	public static function write($q) {
		$res = self::$db->query($q);
		if (false !== $res) {
			return self::$db->affected_rows;
		}
		return false;
	}

	public static function lastid() {
		return self::$db->insert_id;
	}

	public static function escape($s) {
		return self::$db->real_escape_string($s);
	}

}