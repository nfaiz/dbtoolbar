![GitHub](https://img.shields.io/github/license/nfaiz/dbtoolbar)
![GitHub repo size](https://img.shields.io/github/repo-size/nfaiz/dbtoolbar?label=size)
![Hits](https://hits.seeyoufarm.com/api/count/incr/badge.svg?url=nfaiz/dbtoolbar)

# QHighlighter
SQL Syntax Highlighter for CodeIgniter 4.

## Description
Alternative SQL Syntax Highlighter for CodeIgniter 4 Database Debug Toolbar.

## Table of contents
  * [Requirement](#requirement)
  * [Installation](#installation)
  * [Setup Config File](#setup-config-file)
    * [Toolbar](#toolbar)
    * [Events](#events)
  * [Configuration](#configuration) (Optional)
  * [ScreenShot](#screenshot)
  * [Credit](#credit)


## Requirement
* [Codeigniter 4](https://github.com/codeigniter4/CodeIgniter4)
* [Highlight.php](https://github.com/scrivo/highlight.php)


## Installation
Install library via composer:

    composer require nfaiz/dbtoolbar


## Setup Config File

* [Toolbar.php](#toolbar)
* [Events.php](#events)


### Toolbar
Open `app/Config/Toolbar.php`

Replace default database collector class `Database::class` to `\Nfaiz\DbToolbar\Collectors\Database::class`

```diff

public $collectors = [
    Timers::class,
-   Database::class,
+   \Nfaiz\DbToolbar\Collectors\Database::class,
    Logs::class,
    Views::class,
    // \CodeIgniter\Debug\Toolbar\Collectors\Cache::class,
    Files::class,
    Routes::class,
    Events::class,
];
```

### Events
Open `app/Config/Events.php`

Replace default query collector to `Events::on('DBQuery', 'Nfaiz\DbToolbar\Collectors\Database::collect');`

```diff
if (CI_DEBUG && ! is_cli()) {
- Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
+ Events::on('DBQuery', 'Nfaiz\DbToolbar\Collectors\Database::collect');
  Services::toolbar()->respond();
}
```

Refresh page to see the result.


## Configuration

Open `app/Config/Toolbar.php` and add properties below. (Optional)

```php

/**
 * -------------------------------------------------------------
 * Query Theme
 * -------------------------------------------------------------
 * 
 * Configuration for light and dark mode SQL Syntax Highlighter.
 * Refer https://github.com/scrivo/highlight.php/tree/master/src/Highlight/styles or
 * use \HighlightUtilities\getAvailableStyleSheets(); for available stylesheets.
 *
 * @var array
 */
public $queryTheme = [
    'light' => 'default', // atom-one-light
    'dark'  => 'dark'
];

/**
 * -------------------------------------------------------------
 * Bottom Margin Between Diplayed Query in Toolbar
 * -------------------------------------------------------------
 * 
 * Value in px
 * 
 * @var int
 */
public $queryMarginBottom = 4;

/**
 * -------------------------------------------------------------
 * Log Queries
 * -------------------------------------------------------------
 *
 * Make sure to set threshold to minimum 7 at app/Config/Logger.php
 * Logs can be found at ROOTPATH/writable/logs
 *
 * @var boolean
 */
public $logger = false;
```

## Screenshot

### Default Database Toolbar

* Light<br />
<img src="https://user-images.githubusercontent.com/1330109/128514930-c450fef7-2008-4991-bf95-92c1acc76426.png" alt="Light mode">

* Dark<br />
<img src="https://user-images.githubusercontent.com/1330109/128515006-1acf19e3-0db4-487c-9fca-82c19670fe5e.png" alt="Dark mode">

### After using DbToolbar

* Light (using default)<br />
<img src="https://user-images.githubusercontent.com/1330109/128515151-c1289da9-1f6a-4561-9fb8-ddb6fc8e9f0f.png" alt="Light mode">

* Dark (using dark)<br />
<img src="https://user-images.githubusercontent.com/1330109/128515327-f0e6cda6-d443-4625-a44a-4dffc2caf9ee.png" alt="Dark mode">

### Another example

* Light (using atom-one-light)
<img src="https://user-images.githubusercontent.com/1330109/128515815-01153f90-e140-48ed-93dc-b955d8b570e7.png" alt="Light mode">

* Dark (using atom-one-dark)
<img src="https://user-images.githubusercontent.com/1330109/128515952-39358146-0d32-42c4-a27d-80789503290b.png" alt="Dark mode">

## Credit
* Inspired by this [pull request](https://github.com/codeigniter4/CodeIgniter4/pull/3515)
