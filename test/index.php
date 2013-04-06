<?php

include_once(__DIR__.'/functions.php');

header('Content-Type: text/html; charset=utf-8');
echo "<pre>";


$payload = new stdClass();
$payload->appkey = 'test';
$payload->cmd = 'login';

$payload->params->name = 'Ivo';
$payload->params->pass = '123';

debug("----REQUEST-----");
debug(print_r($payload,1));

$r = json_decode(execute($payload));

debug("----RESPONSE----");
debug(print_r($r,1));

debug("EVENTS");

$person = $r;

$payload = new stdClass();
$payload->appkey = 'test';
$payload->cmd = 'events';

$payload->params->count = 1;
$payload->params->pid = $person->pid;
$payload->params->radius = 4;
$payload->params->interests = $person->interests;
$payload->params->start = '2013-04-05 15:00:12';
$payload->params->end = '2013-04-08 21:00:12';
$payload->params->city = 'София';

debug("----REQUEST-----");
debug(print_r($payload,1));

$r = json_decode(execute($payload));

debug("----RESPONSE----");
debug(print_r($r,1));

$payload = new stdClass();
$payload->appkey = 'test';
$payload->cmd = 'events';

$payload->params->pid = $person->pid;
$payload->params->radius = 4;
$payload->params->interests = $person->interests;
$payload->params->start = '2013-04-05 15:00:12';
$payload->params->end = '2013-04-08 21:00:12';
$payload->params->city = 'София';

debug("----REQUEST-----");
debug(print_r($payload,1));

$r = json_decode(execute($payload));

debug("----RESPONSE----");
debug(print_r($r,1));

$payload = new stdClass();
$payload->appkey = 'test';
$payload->cmd = 'persons';

$payload->params->count = 1;
$payload->params->pid = $person->pid;
$payload->params->interests = $person->interests;

debug("----REQUEST-----");
debug(print_r($payload,1));

$r = json_decode(execute($payload));

debug("----RESPONSE----");
debug(print_r($r,1));


$payload = new stdClass();
$payload->appkey = 'test';
$payload->cmd = 'persons';

$payload->params->pid = $person->pid;
$payload->params->interests = $person->interests;

debug("----REQUEST-----");
debug(print_r($payload,1));

$r = json_decode(execute($payload));

debug("----RESPONSE----");
debug(print_r($r,1));
