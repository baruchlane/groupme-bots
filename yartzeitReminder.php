<?php
//if( php_sapi_name() !== 'cli' ) {
//    die("Meant to be run from command line");
//}

function find_wordpress_base_path() {
    $dir = dirname(__FILE__);
    do {
        //it is possible to check for other files here
        if( file_exists($dir."/wp-config.php") ) {
            return $dir;
        }
    } while( $dir = realpath("$dir/..") );
    return null;
}

define( 'BASE_PATH', find_wordpress_base_path()."/" );
define('WP_USE_THEMES', false);
global $wp, $wp_query, $wp_the_query, $wp_rewrite, $wp_did_header;
require(BASE_PATH . 'wp-load.php');

$a = 1;
$ignore = [6.3, 6.6, 7, 8, 9, 10, 20];
$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}rg_lead_detail ORDER BY lead_id, field_number");
$fields = ['first','last', 'email', 'relation', 'death', 'night'];
$people = [];
$i = 0;
foreach ($results as $result) {
    if (in_array($result->field_number, $ignore)) {
        continue;
    }
    $people[$result->lead_id][$fields[$i]] = $result->value;
    $i = ($i + 1) % 6;
}
echo '<table border="1"><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Relative</th><th>Date of Death (Gregorian)</th><th>Date of Death (Hebrew)</th><th>Next Yartzeit (Gregorian)</th></tr>';
foreach ($people as $person) {
    echo '<tr>';
    echo "<td>{$person['first']}</td>";
    echo "<td>{$person['last']}</td>";
    echo "<td>{$person['email']}</td>";
    echo "<td>{$person['relation']}</td>";
    $death = new \DateTime($person['death']);
    echo "<td>{$death->format('m/d/Y')}</td>";

    $englishDate = new \DateTime($person['death']);
    list($gregYear, $gregMonth, $gregDay) = explode('-', $person['death']);
    if ($person['night'] != 'Before Sunset') {
        $gregDay++;
    }
    list($hebMonth, $hebDay, $hebYear) = explode('/', jdtojewish(gregoriantojd($gregMonth, $gregDay, $gregYear)));
    echo "<td>$hebMonth/$hebDay/$hebYear</td>";
    while (($next = new \DateTime(jdtogregorian(jewishtojd($hebMonth, $hebDay, $hebYear++)))) < (new \DateTime()));
    echo "<td>{$next->format('m/d/Y')}</td>";
    echo '</tr>';
}
echo '<table>';