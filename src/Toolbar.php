<?php

namespace Nfaiz\DbToolbar;

use \Highlight\Highlighter;

class Toolbar
{
    protected static $queries = [];

    private $config;

    function __construct($queries)
    {
        static::$queries = $queries;
        $this->config = config('Toolbar');
    }

    /**
     * Format Data Display
     *
     * @return string
     */
    public function display(): string
    {
        $queries = [];

        foreach (static::$queries as $query) {
            $duration = (float) number_format($query['query']->getDuration(5), 5) * 1000;
            $numRows = $query['numRows'] ?? null;
            $isDuplicate = $query['duplicate'] === true;

            // Find the first line that doesn't include `system` in the backtrace
            $line = [];

            foreach ($query['trace'] as &$traceLine) {
                // Clean up the file paths
                $traceLine['file'] = str_ireplace(APPPATH, 'APPPATH/', $traceLine['file']);
                $traceLine['file'] = str_ireplace(SYSTEMPATH, 'SYSTEMPATH/', $traceLine['file']);
                if (defined('VENDORPATH')) {
                    // VENDORPATH is not defined unless `vendor/autoload.php` exists
                    $traceLine['file'] = str_ireplace(VENDORPATH, 'VENDORPATH/', $traceLine['file']);
                }
                $traceLine['file'] = str_ireplace(ROOTPATH, 'ROOTPATH/', $traceLine['file']);

                if (strpos($traceLine['file'], 'SYSTEMPATH') !== false) {
                    continue;
                }
                $line = empty($line) ? $traceLine : $line;
            }

            $queries[] = [
                'hover'      => $isDuplicate ? 'This query was called more than once.' : '',
                'class'      => $isDuplicate ? 'duplicate' : '',
                'duration'   => $duration . ' ms',
                'sql'        => $this->highlightSql($query['sql']),
                'numRows'    => is_int($numRows) ? number_format($numRows) : null,
                'location'   => $query['location'] ?? null,
                'trace'      => $query['trace'],
                'trace-file' => str_replace(ROOTPATH, '/', $line['file'] ?? ''),
                'trace-line' => $line['line'] ?? '',
                'qid'        => md5(rand() . microtime()),
            ];

            if (isset($this->config->logger) && $this->config->logger === true) {
                log_message('info', 'Query time: {duration}ms'. PHP_EOL . '{sql}' . PHP_EOL, [
                    'sql' => $query['sql'],
                    'duration' => $duration,
                ]);
            }
        }

        return $this->render($queries);
    }

    /**
     * Returns Highlighted SQL
     *
     * @return string
     */
    public function highlightSql(string $sql = ''): string
    {
        $hl = new Highlighter();

        try {
            $highlighted = $hl->highlight('sql', $sql);
            return '<code class="hljs hljs-pre-line sql">' . $highlighted->value . '</code>';
        } catch (\DomainException $e) {
            return '<code><pre>' . $sql . '</code></pre>';
        }
    }

    /**
     * Render Queries
     *
     * @return string
     */
    public function render(array $queries): string
    {
        if (empty($queries)) {
            return '';
        }

        $data = [
            'queries' => $queries,
            'hlstyle' => $this->getStyle()
        ];

        return service('parser')->setData($data)->render($this->config->queryTpl ?? 'Nfaiz\DbToolbar\Views\database.tpl');
    }

    /**
     * Returns style
     *
     * @return string
     */
    private function getStyle(): string
    {
        $light = $this->getStyleSheetName('light');
        $dark = $this->getStyleSheetName('dark');
        $darkStyle = str_replace('.hljs', '#toolbarContainer.dark .hljs', \HighlightUtilities\getStyleSheet($dark));
        $style = \HighlightUtilities\getStyleSheet($light) . $darkStyle;
        $margin = $this->getBottomMargin();

        return <<<STYLE
        <STYLE>
        .hljs-pre-line{white-space:pre-line;margin-bottom:{$margin}px;}
        {$style}
        </STYLE>
        STYLE;
    }

    /**
     * Returns StyleSyheet Name
     *
     * @return string
     */
    public function getStyleSheetName(string $mode): string
    {
        $list = \HighlightUtilities\getAvailableStyleSheets();

        if (! isset($this->config->queryTheme[$mode]) ||
            ! in_array($this->config->queryTheme[$mode], $list, true)) {
            return $mode == 'light' ? 'default' : 'dark';
        }

        return $this->config->queryTheme[$mode];
    }

    /**
     * Returns Bottom Margin
     *
     * @return integer
     */
    private function getBottomMargin(): int
    {
        if (! isset($this->config->queryMarginBottom) ||
            ! is_numeric($this->config->queryMarginBottom)) {
            return 4;
        }

        return $this->config->queryMarginBottom;
    }
}