![GitHub](https://img.shields.io/github/license/nfaiz/dbtoolbar)
![GitHub repo size](https://img.shields.io/github/repo-size/nfaiz/dbtoolbar?label=size)
![Hits](https://hits.seeyoufarm.com/api/count/incr/badge.svg?url=nfaiz/dbtoolbar)

# DbToolbar
SQL Syntax Highlighter for CodeIgniter 4 Database Debug Toolbar.

## Description
Alternative SQL Syntax Highlighter for CodeIgniter 4 Database Debug Toolbar.

## Table of contents
  * [Requirement](#Requirement)
  * [Installation](#installation)
  * [Setup Config File](#setup-config-file)
    * [Edit Toolbar](#1-edit-toolbar)
      * [Add DbToolbar Collector to Collectors Property](#i-add-dbtoolbar-collector-to-collectors-property)
      * [Add queryTheme and queryMarginBottom Property](#ii-add-queryTheme-and-queryMarginBottom-property) (Optional)
    * [Create DbToolbar Config File](#2-create-dbtoolbar-config-file) (Optional)
  * [Configuration](#configuration)
    * [Disable Default Database Collector](#1-disable-default-database-collector)
    * [Library Config](#2-library-config)
    * [Change Highlighter Styling](#3-change-query-styling)
      * [Query Highlighter Theme](#i-query-highlighter-theme )
      * [Bottom Margin Between Query](#ii-bottom-margin-between-query)
  * [Screenshot](#screenshot)
    * [Default database toolbar](#default-database-toolbar)
    * [After Using Highlighter](#after-using-highlighter)
    * [Another Example](#another-example)
  * [Credit](#credit)


## Requirement
* [Codeigniter 4](https://github.com/codeigniter4/CodeIgniter4)
* [Highlight.php](https://github.com/scrivo/highlight.php)


## Installation
Install library via composer:

    composer require nfaiz/dbtoolbar


## Setup Config File

* Edit [Toolbar.php](#1-edit-toolbar)
* Create [DbToolbar.php](#2-create-dbtoolbar-config-file) (Optional)

### 1. Edit Toolbar
Open `app/Config/Toolbar.php` file.

#### i. Add DbToolbar collector to Collectors Property
Add `\Nfaiz\DbToolbar\Collectors\Database::class` to **$collectors** property.


```php

public $collectors = [
    Timers::class,
    \Nfaiz\DbToolbar\Collectors\Database::class,
    Database::class,
    Logs::class,
    Views::class,
    // \CodeIgniter\Debug\Toolbar\Collectors\Cache::class,
    Files::class,
    Routes::class,
    Events::class,
];
```

#### ii. Add queryTheme and queryMarginBottom Property
Add **$queryTheme** and **$queryMarginBottom**. Both properties are optional for query highlighter styling.

```php

/**
 * -------------------------------------------------------------
 * Query Theme
 * -------------------------------------------------------------
 * 
 * Configuration for light and dark mode SQL syntax highlighter.
 *
 * @var array
 */
public $queryTheme = [
    'light' => 'default',
    'dark'  => 'dark'
];

/**
 * -------------------------------------------------------------
 * Bottom Margin Between Query
 * -------------------------------------------------------------
 * 
 * Value in px
 * 
 * @var int
 */
public $queryMarginBottom = 4;
```

### 2. Create DbToolbar Config File

Creating DbToolbar config can be done via spark:

    php spark dbtoolbar:config

Or manually create [app/Config/DbToolbar.php](docs/INSTALLATION.md#2-dbtoolbar);


Once library installation and setup config files are completed, refresh page to see the result.


## Configuration


### 1. Disable Default Database Collector
To **disable** default CodeIgniter 4 database collector open `app/Config/Events.php`.
`Comment` or `Remove` default database collector below;

```php
// Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
```

### 2. Library Config
To **configure** DbToolbar, open `app/Config/DbToolbar.php` or [create it](#2-create-dbtoolbar-config-file) if not yet created. 

Change the value accordingly.
| Property | Description | Type | Default |
| --- | --- | --- | --- |
| $collect | To enable/disable DbToolbar collector | Bool | `true` |
| $tabTitle | Title to display at debug toolbar tab | String | `Queries` |
| $logger | To log query using logger. Need to set threshold to minimum 7 in `app/Config/Logger.php` | Bool | `false` |


### 3. Change Query Styling

#### i. Query Highlighter Theme 
To change `Query Highlighter Theme`, find `$queryTheme` property at `app/Config/Toolbar.php` or [add it](#ii-add-queryTheme-and-queryMarginBottom-property) if not yet added.


* Assign stylesheet theme to `light` or `dark` mode. E.g `'github'`
* Available stylesheets can be found using HighlightUtilities. See [highlighter-utilities](https://github.com/scrivo/highlight.php#highlighter-utilities) for more information


E.g Using `\HighlightUtilities` in **Controller**

```php
    // Get available stylesheets.
    $availableStyleSheets = \HighlightUtilities\getAvailableStyleSheets();
    d($availableStyleSheets);
```

#### ii. Bottom Margin Between Query
To change `Bottom Margin Between Query`, find `$queryMarginBottom` property at `app/Config/Toolbar.php` or [add it](#ii-add-queryTheme-and-queryMarginBottom-property) if not yet added.

* Assign value with integer type
* value is in pixels (`px`)


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
* [Highlight.php](https://github.com/scrivo/highlight.php)
* Inspired by this [pull request](https://github.com/codeigniter4/CodeIgniter4/pull/3515)
