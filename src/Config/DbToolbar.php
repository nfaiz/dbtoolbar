<?php 

namespace Nfaiz\DbToolbar\Config;

use CodeIgniter\Config\BaseConfig;

class DbToolbar extends BaseConfig
{
    /**
     * -------------------------------------------------------------
     * Collect Queries?
     * -------------------------------------------------------------
     *
     * To enable/disable query collector
     * 
     * @var boolean
     */
    public $collect = true;

    /**
     * -------------------------------------------------------------
     * Tab Title
     * -------------------------------------------------------------
     *
     * Tab title display
     * 
     * @var string
     */
    public $tabTitle = 'Queries';

    /**
     * -------------------------------------------------------------
     * Log Queries
     * -------------------------------------------------------------
     *
     * Need to set threshold to minimum 7 at app/Config/Logger.php
     * 
     * @var boolean
     */
    public $logger = false;
}