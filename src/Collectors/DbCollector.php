<?php

/**
 * This file is not part of the CodeIgniter 4 framework.
 */

namespace Nfaiz\DbToolbar\Collectors;

use CodeIgniter\Debug\Toolbar\Collectors\BaseCollector;
use CodeIgniter\Database\Query;
use Nfaiz\DbToolbar\DbToolbar;
use Config\Toolbar;

/**
 * Collector for the Database tab of the Debug Toolbar.
 */
class DbCollector extends BaseCollector
{
    /**
     * Whether this collector has timeline data.
     *
     * @var boolean
     */
    protected $hasTimeline = true;

    /**
     * Whether this collector should display its own tab.
     *
     * @var boolean
     */
    protected $hasTabContent = true;

    /**
     * Whether this collector has data for the Vars tab.
     *
     * @var boolean
     */
    protected $hasVarData = false;

    /**
     * The name used to reference this collector in the toolbar.
     *
     * @var string
     */
    protected $title = 'Queries';

    /**
     * Array of database connections.
     *
     * @var array
     */
    protected $connections;

    /**
     * The query instances that have been collected
     * through the DBQuery Event.
     *
     * @var Query[]
     */
    protected static $queries = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->getConnections();
    }

    /**
     * The static method used during Events to collect
     * data.
     *
     * @param Query $query
     *
     * @internal param $ array \CodeIgniter\Database\Query
     */
    public static function collect(Query $query)
    {
        $config = config(Toolbar::class);

        // Provide default in case it's not set
        $max = $config->maxQueries ?: 100;

        if (count(static::$queries) < $max) {
            $queryString = $query->getQuery();

            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

            if (! is_cli()) {
                // when called in the browser, the first two trace arrays
                // are from the DB event trigger, which are unneeded
                $backtrace = array_slice($backtrace, 2);
            }

            static::$queries[] = [
                'query'         => $query,
                'sql'           => $queryString,
                'duplicate'     => in_array($queryString, array_column(static::$queries, 'sql', null), true),
                'trace'         => $backtrace,
                'duration'      => (float) number_format($query->getDuration(5), 5) * 1000,
                'thisRepoFolder'=> 'dbtoolbar',
            ];
        }
    }

    /**
     * Returns timeline data formatted for the toolbar.
     *
     * @return array The formatted data or an empty array.
     */
    protected function formatTimelineData(): array
    {
        $data = [];

        foreach ($this->connections as $alias => $connection) {
            // Connection Time
            $data[] = [
                'name'      => 'Connecting to Database: "' . $alias . '"',
                'component' => 'Database',
                'start'     => $connection->getConnectStart(),
                'duration'  => $connection->getConnectDuration(),
            ];
        }

        foreach (static::$queries as $query) {
            $data[] = [
                'name'      => 'Query',
                'component' => 'Database',
                'start'     => $query['query']->getStartTime(true),
                'duration'  => $query['query']->getDuration(),
                'query'     => $query['query']->debugToolbarDisplay(),
            ];
        }

        return $data;
    }

    /**
     * Returns the data of this collector to be formatted in the toolbar
     *
     * @return mixed
     */
    public function display(): string
    {
        $dbToolbar = new DbToolbar(static::$queries);
        return $dbToolbar->display();
    }

    /**
     * Gets the "badge" value for the button.
     */
    public function getBadgeValue(): int
    {
        return count(static::$queries);
    }

    /**
     * Information to be displayed next to the title.
     *
     * @return string The number of queries (in parentheses) or an empty string.
     */
    public function getTitleDetails(): string
    {
        $this->getConnections();

        $queryCount  = count(static::$queries);
        $uniqueCount = count(array_filter(static::$queries, static function ($query) {
            return $query['duplicate'] === false;
        }));
        $connectionCount = count($this->connections);

        return sprintf(
            '(%d total Quer%s, %d %s unique across %d Connection%s)',
            $queryCount,
            $queryCount > 1 ? 'ies' : 'y',
            $uniqueCount,
            $uniqueCount > 1 ? 'of them' : '',
            $connectionCount,
            $connectionCount > 1 ? 's' : ''
        );
    }

    /**
     * Does this collector have any data collected?
     */
    public function isEmpty(): bool
    {
        return empty(static::$queries);
    }

    /**
     * Display the icon.
     *
     * Icon from https://icons8.com - 1em package
     */
    public function icon(): string
    {
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAACgklEQVR4nO2ay2oUQRSGP0FBN3FmXCdmFaPxATS6EMnGB9DoC0SD8waarREJqDt1IS69QkhcCMkYTOIzCK7EhRcyDAluEsWMFPwNRTNkqmequytSP9Rius91uqr/U6ca+sdJ4BowAzwD1oHPwFegBfzRaOmaubcm2RnpjlICjgHTwCvgB9D2NIytl8AN+cgNl4A3wE4qgJ/APHAPmAIu6h8+DlSBQxpVXRuVzJR05mXDtrkjX8anN5zVdEmc/AWW9M+d8uTjgGxNA8vykfhbVww94wjwBNiVwSZwGxgkfwxq/TTl28TwEDiY1dCA9RS2gTvAUYpHBZi1pvM7xeb8mN9a8/8c5eO8tY4WFWNXXJXCL2CEcDCimExsV1wUViRsFl5ouKnYGi7CWxI28zM0VBXbpotwO+BEalZ8XZEImscYGuq9JBLyYm+7KNilwgZwgfIx3qGu64pEcNmqe2ZLWjMV4K5FiEu9JGLKgQfW76bKhqH842coVaKYcV8xZU4kgWH2j6misaGXwZgry3aBsXFaNt93KBrH94jPOZEEpqR+rdorvY4WgDlVxBOqZIc7lPHDSn5CsnPS3UjZ3JavTmV834nY7/LrwAvgu8eN1TfgufYptT7iyy4onFB9dgt4CqwCn4Av2t7+1mjpmrn3QbJGZzLja76dNZHI7DmiHpmdyOxeUInMTmR2IrMTmX1vRGYvAPXI7ERm94JKZHYisxOZnZyYfSvjVrfIPXstSzd+ZR80sRsuwpP7oIl92bXrt2idIZrzu5DOEBeydDcH9JlFaE3s1SynuvY5++PUOXtZTexd4BFw2PeXD0U2sdeAM3hEKE1sbyi7iZ0bim5i81/jHwn5KgDx2BeAAAAAAElFTkSuQmCC';
    }

    /**
     * Gets the connections from the database config
     */
    private function getConnections()
    {
        $this->connections = \Config\Database::getConnections();
    }
}