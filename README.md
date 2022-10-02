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
  * [Upgrading](#upgrading)
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

### To remove Default Database Collector.

1. Open `app/Config/Toolbar.php` and comment `Database::class` from `$collectors` property.

```php

public $collectors = [
    // Database::class,
];
```

2. Open `app/Config/Events.php` and comment `Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');` event.

```php
if (CI_DEBUG && ! is_cli()) {
  // Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
  Services::toolbar()->respond();
}
```

### To change Css Theme. (Optional)

Open `app/Config/Toolbar.php` add/edit $queryTheme.

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
    'light' => 'atom-one-light',
    'dark'  => 'atom-one-dark'
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
 * Please set threshold to minimum 7 at app/Config/Logger.php
 * Logs can be found at ROOTPATH/writable/logs
 *
 * @var boolean
 */
public $logger = false;

```

## Upgrading
Upgrading from 0.9.7 to 0.9.8

* [Toolbar.php](#toolbar)
* [Events.php](#events)


### Toolbar
Open `app/Config/Toolbar.php` and remove `\Nfaiz\DbToolbar\Collectors\Database::class` from `$collectors` property.

```diff

public $collectors = [
    ..
-   \Nfaiz\DbToolbar\Collectors\Database::class,
    ..
];
```

### Events
Open `app/Config/Events.php` and remove `\Nfaiz\DbToolbar\Collectors\Database::class` event.

```diff
if (CI_DEBUG && ! is_cli()) {
  ..
- Events::on('DBQuery', 'Nfaiz\DbToolbar\Collectors\Database::collect');
  Services::toolbar()->respond();
}
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
