<?php
date_default_timezone_set('UTC');
include('Decedent.php');
$dates = [
    '1940-01-11',
    '1976-02-13',
    '1897-11-01',
    '1980-10-21',
    '2004-12-30',
    '1933-04-10'
];
foreach ($dates as $k => $date) {
    $decedent = new Decedent();
    $decedent->set( Decedent::ENGLISH_DEATH_DATE, $date );
    echo ($k+1) . ': ' . $decedent->calculateDateOfNextYartzeit()->format( 'Y-m-d' ) .'<br>';
}