<?php
ini_set('date.timezone', 'America/New_York');
chdir(dirname(dirname(__FILE__)));
function __autoload($class_name)
{
    require_once 'src/' . $class_name . '.php';
}

echo 'shabbos.php';
//$shabbosBot = new GroupMeService('shabbos');
//$shabbosBot->sendRawMessage('test');