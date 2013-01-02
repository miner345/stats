<?php

require_once('stats.class.php');

$stats = new Stats('host','user','password','database',$page);

$stats->cue();
$stats->load();

echo 'Diese Website wurde insgesamt '.$stats->total_hits.' mal von '.$stats->total_visitors.' Besuchern aufgerufen. Diese einzelne Seite wurde '.$stats->page_hits.' mal von '.$stats->page_visitors.' Besuchern aufgerufen. Du hast diese Website '.$stats->ip_hits.' mal aufgerufen und auf dieser einzelnen Seite warst du bereits '.$stats->ip_page_hits.' mal.';



?>
