![GitHub](https://img.shields.io/github/license/nfaiz/dbtoolbar)
![GitHub repo size](https://img.shields.io/github/repo-size/nfaiz/dbtoolbar?label=size)
![Hits](https://hits.seeyoufarm.com/api/count/incr/badge.svg?url=nfaiz/dbtoolbar)

# Query Highlighter

## Description
CodeIgniter 4 Database Debug Toolbar Query Highlighter.

## Table of contents
  * [Requirement](#requirement)
  * [Installation](#installation)
  * [Configuration](#configuration) (Optional)
  * [ScreenShot](#screenshot)
  * [Credit](#credit)

## Requirement
* [Codeigniter 4](https://github.com/codeigniter4/CodeIgniter4)
* [Highlight.php](https://github.com/scrivo/highlight.php)


## Installation
Install library via composer:

    composer require nfaiz/dbtoolbar

Query Highlighter is located at DbQueries tab (Debug Toolbar)

## Configuration

### Remove Default Database Tab

1. Open and comment `Database::class` from `$collectors` property in `app/Config/Toolbar.php`.

```php

public array $collectors = [
    // Database::class,
];
```

2. Open and comment `Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');` in `app/Config/Events.php`.

```php
if (CI_DEBUG && ! is_cli()) {
  // Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
  Services::toolbar()->respond();
}
```

### Modify Settings.

Open and add properties below in `app/Config/Toolbar.php` accordingly.

```php

/**
 * -------------------------------------------------------------
 * Disable DbToolbar query Highlighter
 * -------------------------------------------------------------
 * 
 * To disable DbToolbar query highlighter, change value to true
 *
 * @var bool
 */
public bool $dbToolbarDisable = false;

/**
 * -------------------------------------------------------------
 * DbToolbar Theme
 * -------------------------------------------------------------
 * 
 * Configuration for light and dark mode SQL Syntax Highlighter.
 * Refer https://github.com/scrivo/highlight.php/tree/master/src/Highlight/styles or
 * use \HighlightUtilities\getAvailableStyleSheets(); for available stylesheets.
 *
 * @var array
 */
public array $dbToolbarTheme = [
    'light' => 'atom-one-light',
    'dark'  => 'atom-one-dark'
];

/**
 * -------------------------------------------------------------
 * DbToolbar View
 * -------------------------------------------------------------
 * 
 * To override DbToolbar SQL Syntax Highlighter view.
 *
 * @var array
 */
public string $dbToolbarTpl = 'Nfaiz\DbToolbar\Views\database.tpl';

/**
 * -------------------------------------------------------------
 * Bottom Margin Between Diplayed Query in Toolbar
 * -------------------------------------------------------------
 * 
 * Value in px
 * 
 * @var int
 */
public int $dbToolbarMarginBottom = 4;

/**
 * -------------------------------------------------------------
 * Log Queries
 * -------------------------------------------------------------
 *
 * Please set threshold to minimum 7 at app/Config/Logger.php
 * Logs can be found at ROOTPATH/writable/logs
 *
 * @var boolean
 */
public bool $dbToolbarLogger = false;

```

#### Custom Syntax Highlighter view.

Open `app/Config/Toolbar.php` and add/edit template view file using `$dbToolbarTpl` property.  
You can create your own view and you change it accordingly. For Example `public $dbToolbarTpl = dbtoolbar/database;` 

Views/dbtoolbar/database.php.
```php
{! hlstyle !}
<table>
    <thead>
        <tr>
            <th class="debug-bar-width6r">Time</th>
            <th>Query String</th>
        </tr>
    </thead>
    <tbody>
    {queries}
        <tr class="{class}" title="{hover}" data-toggle="{qid}-trace">
            <td class="narrow" style="vertical-align: top;">{duration}</td>
            <td><u>{trace-file}</u>{! sql !}</td>
        </tr>
        <tr class="muted debug-bar-ndisplay" id="{qid}-trace">
            <td></td>
            <td>
            {trace}
                {index}<strong>{file}</strong><br/>
                {function}<br/><br/>
            {/trace}
            </td>
        </tr>
    {/queries}
    </tbody>
</table>
```

## Screenshot

### Default Database Toolbar

* Light<br />
<img src="https://user-images.githubusercontent.com/1330109/193412805-a923b570-a4b1-47e6-956c-3f9f97e8c2d8.png" alt="Light mode">

* Dark<br />
<img src="https://user-images.githubusercontent.com/1330109/193412939-b132801a-a639-4d1e-a57e-c2df1d628a6d.png" alt="Dark mode">

### Using DbToolbar

* Light
<img src="https://user-images.githubusercontent.com/1330109/193412867-83603790-0c44-402b-b790-4f3d6576c412.png" alt="Light mode">

* Dark
<img src="https://user-images.githubusercontent.com/1330109/193412970-faa3896e-8425-44a5-961e-ca9e553fecd9.png" alt="Dark mode">

## Credit
* Inspired by this [pull request](https://github.com/codeigniter4/CodeIgniter4/pull/3515)