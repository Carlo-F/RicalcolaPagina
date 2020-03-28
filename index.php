<?php
set_time_limit(0);

require_once 'src/RicalcolaPagina.php';
require_once 'functions.php';

$ricalcolaPagina = new carloF\RicalcolaPagina("brute-thc.txt","http://localhost/test/calcolaPagina/test_area/",".html");

$ricalcolaPagina->ricalcola();