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
    public function display(string $template = 'Nfaiz\DbToolbar\Views\queries.tpl'): string
    {
        $queries = [];

        foreach (static::$queries as $query)
        {
            $duration = (float) number_format($query['duration'], 5) * 1000;

            $numRows = $query['numRows'] ?? null;

            $queries[] = [
                'duration' => $duration . ' ms',
                'sql'      => $this->highlightSql($query['sql']),
                'numRows'  => is_int($numRows) ? number_format($numRows) : null,
                'location' => $query['location'] ?? null,
            ];

            if (isset($this->config->logger) && $this->config->logger === true)
            {
                log_message('info', 'Query time: {duration}ms'. PHP_EOL . '{sql}' . PHP_EOL, [
                    'sql' => $query['sql'],
                    'duration' => $duration
                ]);
            }
        }

        return $this->render($queries, $template);
    }

    /**
     * Returns Highlighted SQL
     *
     * @return string
     */
    public function highlightSql(string $sql = ''): string
    {
        $hl = new Highlighter();

        try
        {
            $highlighted = $hl->highlight('sql', $sql);

            return '<code class="hljs hljs-pre-line sql">' . $highlighted->value . '</code>';
        }
        catch (\DomainException $e) {
            return '<code><pre>' . $sql . '</code></pre>';
        }
    }

    /**
     * Render Queries
     *
     * @return string
     */
    public function render(array $queries, string $parserPath): string
    {
        if (empty($queries))
        {
            return '';
        }

        $data = [
            'queries' => $queries,
            'hlstyle' => $this->getStyle()
        ];

        return service('parser')->setData($data)->render($parserPath);
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
        <style>
        .hljs-pre-line{white-space:pre-line;margin-bottom:{$margin}px;}
        {$style}
        </style>
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

        if (! isset($this->config->queryTheme[$mode]) || ! in_array($this->config->queryTheme[$mode], $list, true))
        {
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
        if (! isset($this->config->queryMarginBottom) || ! is_numeric($this->config->queryMarginBottom))
        {
            return 4;
        }

        return $this->config->queryMarginBottom;
    }
}