<?php

namespace Nfaiz\DbToolbar;

use \Nfaiz\DbToolbar\Formatter;

class Queries
{
    protected static $queries = [];

    function __construct($queries)
    {
        static::$queries = $queries;
    }

    public function display(): string
    {
        if (class_exists('Highlight\Highlighter') 
            && class_exists('Nfaiz\DbToolbar\Formatter'))
        {
            $formatter = new Formatter();

            $queries = [];

            $config = config(DbToolbar::class);

            foreach (static::$queries as $query) 
            {
                $duration = (float) $query->getDuration(5) * 1000;

                $queries[] = [
                    'duration' => $duration . ' ms',
                    'sql'      => $formatter->highlightSql($query->getQuery()),
                ];

                if ($config->logger === true)
                {
                    log_message('info', 'Query time: {duration}ms'. PHP_EOL . '{sql}' . PHP_EOL, [
                        'sql' => $query->getQuery(),
                        'duration' => $duration
                    ]);
                }
            }

            return $formatter->render($queries, 'Nfaiz\DbToolbar\Views\queries.tpl');
        }

        throw new \Exception("Dependencies not met. Please check installation and setup.", 1);
    }
}