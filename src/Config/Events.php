<?php

namespace Nfaiz\DbToolbar\Config;

use CodeIgniter\Events\Events;

Events::on('pre_system', function () {

    $config = config(DbToolbar::class);

    if ($config->collect === true)
    {
        Events::on('DBQuery', 'Nfaiz\DbToolbar\Collectors\Database::collect');
    }

});