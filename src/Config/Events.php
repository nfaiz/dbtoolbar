<?php

use CodeIgniter\Events\Events;

if (CI_DEBUG && ! is_cli()) {
	Events::on('DBQuery', 'Nfaiz\DbToolbar\Collectors\Database::collect');
}