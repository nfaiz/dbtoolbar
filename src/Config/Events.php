<?php

use CodeIgniter\Events\Events;
use Config\Toolbar;

$config = config(Toolbar::class);
$dbToolbarDisable = $config->dbToolbarDisable ?? false;

if (CI_DEBUG && ! is_cli() && $dbToolbarDisable !== true) {
    Events::on('DBQuery', 'Nfaiz\DbToolbar\Collectors\DbCollector::collect');
}