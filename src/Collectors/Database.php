<?php

/**
 * This file is not part of the CodeIgniter 4 framework.
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nfaiz\DbToolbar\Collectors;

use CodeIgniter\Database\Query;
use CodeIgniter\Debug\Toolbar\Collectors\BaseCollector;

/**
 * Collector for the Database tab of the Debug Toolbar.
 */
class Database extends BaseCollector
{
    /**
     * Whether this collector has timeline data.
     *
     * @var bool
     */
    protected $hasTimeline = true;

    /**
     * Whether this collector should display its own tab.
     *
     * @var bool
     */
    protected $hasTabContent = true;

    /**
     * Whether this collector has data for the Vars tab.
     *
     * @var bool
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
        $this->connections = \Config\Database::getConnections();

        $config = config(DbToolbar::class);

        $this->title = $config->tabTitle;
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
        $config = config('Toolbar');

        // Provide default in case it's not set
        $max = $config->maxQueries ?: 100;

        if (count(static::$queries) < $max) {
            static::$queries[] = $query;
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
                'start'     => $query->getStartTime(true),
                'duration'  => $query->getDuration(),
            ];
        }

        return $data;
    }

    /**
     * Returns the data of this collector to be formatted in the toolbar
     *
     * @return mixed
     */
    public function display()
    {
        if (class_exists('Highlight\Highlighter') 
            && class_exists('Nfaiz\DbToolbar\Formatter'))
        {
            $hl = new \Nfaiz\DbToolbar\Formatter();

            $queries = [];

            foreach (static::$queries as $query) {
                $queries[] = [
                    'duration' => ((float) $query->getDuration(5) * 1000) . ' ms',
                    'sql'      => $hl->highlightSql($query->getQuery()),
                ];
            }

            return $hl->render($queries);
        }

        throw new \Exception("Dependencies not met. Please check installation and setup.", 1);
    }

    /**
     * Gets the "badge" value for the button.
     *
     * @return int
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
        return '(' . count(static::$queries) . ' Queries across ' . ($countConnection = count($this->connections)) . ' Connection' .
            ($countConnection > 1 ? 's' : '') . ')';
    }

    /**
     * Does this collector have any data collected?
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty(static::$queries);
    }

    /**
     * Display the icon.
     *
     * Icon from https://icons8.com - 1em package
     *
     * @return string
     */
    public function icon(): string
    {
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAADMSURBVEhLY6A3YExLSwsA4nIycQDIDIhRWEBqamo/UNF/SjDQjF6ocZgAKPkRiFeEhoYyQ4WIBiA9QAuWAPEHqBAmgLqgHcolGQD1V4DMgHIxwbCxYD+QBqcKINseKo6eWrBioPrtQBq/BcgY5ht0cUIYbBg2AJKkRxCNWkDQgtFUNJwtABr+F6igE8olGQD114HMgHIxAVDyAhA/AlpSA8RYUwoeXAPVex5qHCbIyMgwBCkAuQJIY00huDBUz/mUlBQDqHGjgBjAwAAACexpph6oHSQAAAAASUVORK5CYII=';
    }
}