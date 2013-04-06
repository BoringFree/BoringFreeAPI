<?php

include_once(__DIR__.'/functions.php');

$payload = new stdClass();
$payload->appkey = 'test';
$payload->cmd = 'eventsRegister';

$payload->params->type = 'sport';

$payload->params->pid = 4;
$payload->params->radius = 8;
$payload->params->start = '2013-04-08 19:00:00';
$payload->params->end = '2013-04-08 21:00:00';
$payload->params->title = 'Волейбол за аматьори.';
$payload->params->description = 'Търсим 4 човека.';
$payload->params->city = 'София';
$payload->params->location = 'Зала Академик, кв. Гео Милев';

$r = json_decode(execute($payload));
var_dump($r);

$payload->params->pid = 5;
$payload->params->radius = 5;
$payload->params->start = '2013-04-08 20:00:00';
$payload->params->end = '2013-04-08 21:00:00';
$payload->params->title = 'Тенис за ветерани.';
$payload->params->description = 'Търсим 2 човека за каре. Ниво – средно.';
$payload->params->city = 'София';
$payload->params->location = 'Кортове 15:40, кв. Гео Милев';

$r = json_decode(execute($payload));
var_dump($r);

$payload->params->pid = 6;
$payload->params->radius = 4;
$payload->params->start = '2013-04-08 18:00:00';
$payload->params->end = '2013-04-08 21:00:00';
$payload->params->title = 'Баскетбол 18-30 год.';
$payload->params->description = 'Организираме любителски турнир.';
$payload->params->city = 'София';
$payload->params->location = 'Училище СУЧЕМ Иван Вазов в двора, кв. Гео Милев';

$r = json_decode(execute($payload));
var_dump($r);

$payload->params->pid = 7;
$payload->params->radius = 2;
$payload->params->start = '2013-04-08 19:00:00';
$payload->params->end = '2013-04-08 21:00:00';
$payload->params->title = 'Някой да тичаме заедно в Борисовата.';
$payload->params->description = 'На 35 г. съм и обикновено бягам по 5 км.';
$payload->params->city = 'София';
$payload->params->location = 'Зала Академик, кв. Гео Милев';

$r = json_decode(execute($payload));
var_dump($r);

$payload->params->type = 'restaurant';

$payload->params->pid = 0;
$payload->params->radius = 10;
$payload->params->start = '2013-04-08 10:00:00';
$payload->params->end = '2013-04-08 11:00:00';
$payload->params->title = 'Понички за ученици – 50 ст.';
$payload->params->description = 'Уникална промоция днес в DunkinDonuts – поничка – 50 ст. Поничка с кола – 90 ст.';
$payload->params->city = 'София';
$payload->params->location = 'Dunkin Donuts – бул. Шипченски проход 7';

$r = json_decode(execute($payload));
var_dump($r);

$payload->params->pid = 0;
$payload->params->radius = 6;
$payload->params->start = '2013-04-08 15:00:00';
$payload->params->end = '2013-04-08 18:00:00';
$payload->params->title = 'Малка пица в Дон Вито – 3.50 лв.';
$payload->params->description = 'Само при нас всеки ден след обяд – малка пица за 3.50.';
$payload->params->city = 'София';
$payload->params->location = 'Пицерия Дон Вито, ул. Гео Милев 37а';

$r = json_decode(execute($payload));
var_dump($r);

$payload->params->pid = 0;
$payload->params->radius = 5;
$payload->params->start = '2013-04-08 09:00:00';
$payload->params->end = '2013-04-08 24:00:00';
$payload->params->title = 'Промоция на Heineken';
$payload->params->description = 'Елате, изпите най-много бири за 5 мин. и спечелете 5 пъти по толкова.';
$payload->params->city = 'София';
$payload->params->location = 'VIVACOM HQ, – бул. Цариградско шосе 115И, ет.5';

$r = json_decode(execute($payload));
var_dump($r);

$payload->params->pid = 3;
$payload->params->radius = 2;
$payload->params->start = '2013-04-08 09:00:00';
$payload->params->end = '2013-04-08 11:00:00';
$payload->params->title = 'Някой за кафе...';
$payload->params->description = 'Да обича фотографията. Да е жена. Или мъж. Може и двете.';
$payload->params->city = 'София';
$payload->params->location = 'НБУ';

$r = json_decode(execute($payload));
var_dump($r);
