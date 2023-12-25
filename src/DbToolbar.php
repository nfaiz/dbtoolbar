<?php

namespace Nfaiz\DbToolbar;

use Config\Toolbar;
use \Highlight\Highlighter;

class DbToolbar
{
    protected static $queries = [];

    private object $config;

    function __construct($queries)
    {
        static::$queries = $queries;
        $this->config = config(Toolbar::class);
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
            $numRows = $query['numRows'] ?? 0;
            $thisRepoFolder = $query['thisRepoFolder'] ?? 'this-repo-folder';
            $isDuplicate = $query['duplicate'] === true;

            $firstNonSystemLine = '';

            foreach ($query['trace'] as $index => &$line) {
                // simplify file and line
                if (isset($line['file'])) {
                    $line['file'] = clean_path($line['file']) . ':' . $line['line'];
                    unset($line['line']);
                } else {
                    $line['file'] = '[internal function]';
                }

                // find the first trace line that does not originate from `system/`
                if ($firstNonSystemLine === '' 
                    && strpos($line['file'], 'SYSTEMPATH') === false
                    && strpos($line['file'], $thisRepoFolder) === false
                ) {
                    $firstNonSystemLine = $line['file'];
                }

                // simplify function call
                if (isset($line['class'])) {
                    $line['function'] = $line['class'] . $line['type'] . $line['function'];
                    unset($line['class'], $line['type']);
                }

                if (strrpos($line['function'], '{closure}') === false) {
                    $line['function'] .= '()';
                }

                $line['function'] = str_repeat(chr(0xC2) . chr(0xA0), 8) . $line['function'];

                // add index numbering padded with nonbreaking space
                $indexPadded = str_pad(sprintf('%d', $index + 1), 3, ' ', STR_PAD_LEFT);
                $indexPadded = preg_replace('/\s/', chr(0xC2) . chr(0xA0), $indexPadded);

                $line['index'] = $indexPadded . str_repeat(chr(0xC2) . chr(0xA0), 4);
            }

            $queries[] = [
                'hover'      => $isDuplicate ? 'This query was called more than once.' : '',
                'class'      => $isDuplicate ? 'duplicate' : '',
                'duration'   => $query['duration'] . ' ms',
                'sql'        => $this->highlightSql($query['sql']),
                'trace'      => $query['trace'],
                'trace-file' => $firstNonSystemLine,
                'qid'        => md5(rand() . microtime()),
                'numRows'    => is_int($numRows) ? number_format($numRows) : 0,
            ];

            if ((isset($this->config->dbToolbarLogger) && $this->config->dbToolbarLogger === true)
                || (isset($this->config->logger) && $this->config->logger === true)
               ) {
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
        if ($queries == []) {
            return '';
        }

        $default = 'Nfaiz\DbToolbar\Views\database.tpl';

        $view = $this->config->dbToolbarTpl ?? $this->config->queryTpl ?? $default;

        return service('parser')->setData([
            'queries' => $queries,
            'hlstyle' => $this->getStyle(),
        ])->render($view);
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
        $cssDark = \HighlightUtilities\getStyleSheet($dark);
        $cssLight = \HighlightUtilities\getStyleSheet($light);
        $darkStyle = str_replace('.hljs', '#toolbarContainer.dark .hljs', $cssDark);
        $style = $cssLight . $darkStyle;
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

        // Backward compatibility for queryTheme property
        if (isset($this->config->queryTheme[$mode]) &&
            in_array($this->config->queryTheme[$mode], $list, true)) {
            return $this->config->queryTheme[$mode];
        }

        if (! isset($this->config->dbToolbarTheme[$mode]) ||
            ! in_array($this->config->dbToolbarTheme[$mode], $list, true)) {
            return $mode == 'light' ? 'default' : 'monokai-sublime';
        }

        return $this->config->dbToolbarTheme[$mode];
    }

    /**
     * Returns Bottom Margin
     *
     * @return integer
     */
    private function getBottomMargin(): int
    {
        // Backward compatibility for queryTheme property
        if (isset($this->config->queryMarginBottom) &&
            is_numeric($this->config->queryMarginBottom)) {
            return 4;
        }

        if (! isset($this->config->dbToolbarMarginBottom) ||
            ! is_numeric($this->config->dbToolbarMarginBottom)) {
            return 4;
        }

        return $this->config->dbToolbarMarginBottom;
    }
}