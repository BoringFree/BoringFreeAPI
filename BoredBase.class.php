<?php

class BoredBase {

	public static $interests = array (
		'sport' => 'Спорт',
		'restaurant' => 'Заведения',
		'movie' => 'Кино',
		'music' => 'Музика',
		'art' => 'Изкуство',
		'general' => 'Друго',
		'run' => 'Бягане',
		'basketball' => 'Баскетбол',
		'beer' => 'Бира',
		'coffee' => 'Кафе',
		'tennis' => 'Тенис'
	);

	public static $max_radius = 20;

	public function error($error) {
		return array('error' => $error);
	}

}
