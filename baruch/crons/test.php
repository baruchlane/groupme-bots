<?php 
echo 'moo';

$emailto = 'baruch.lane@gmail.com';
$toname = 'Baruch Lane';
$emailfrom = 'reminders@recitekaddish.com';
$fromname = 'ReciteKaddish';
$subject = 'Test';
$messagebody = 'Hello.';
$headers = 
	'Return-Path: ' . $emailfrom . "\r\n" . 
	'From: ' . $fromname . ' <' . $emailfrom . '>' . "\r\n" . 
	'X-Priority: 3' . "\r\n" . 
	'X-Mailer: PHP ' . phpversion() .  "\r\n" . 
	'Reply-To: ' . $fromname . ' <' . $emailfrom . '>' . "\r\n" .
	'MIME-Version: 1.0' . "\r\n" . 
	'Content-Transfer-Encoding: 8bit' . "\r\n" . 
	'Content-Type: text/plain; charset=UTF-8' . "\r\n";
$params = '-f ' . $emailfrom;
//$test = mail($emailto, $subject, $messagebody, $headers, $params);
//echo $test ? 'Yesss!' : 'Boooo.';
var_dump(new DateTime());
