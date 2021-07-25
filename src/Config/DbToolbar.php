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
     * Bottom Margin Between Queries
     * -------------------------------------------------------------
     * 
     * Value in px
     * 
     * @var int
     */
    public $boxMarginBottom = 4;
}