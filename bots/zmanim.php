<?php
ini_set('date.timezone', 'America/New_York');
chdir(dirname(dirname(__FILE__)));
function __autoload($class_name)
{
    require_once 'src/' . $class_name . '.php';
}

$params = json_decode(file_get_contents("php://input"), true);
file_put_contents('logs/dev.log', json_encode($params) . PHP_EOL, FILE_APPEND | LOCK_EX);
if ($params['sender_type'] != 'bot') {
    $sunsetBot = new Sunset();
    $sunsetBot->pingBot($params['text']);
}

