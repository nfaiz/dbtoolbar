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

            foreach (static::$queries as $query) {
                $queries[] = [
                    'duration' => ((float) $query->getDuration(5) * 1000) . ' ms',
                    'sql'      => $formatter->highlightSql($query->getQuery()),
                ];
            }

            return $formatter->render($queries, 'Nfaiz\DbToolbar\Views\queries.tpl');
        }

        throw new \Exception("Dependencies not met. Please check installation and setup.", 1);
	}

}   