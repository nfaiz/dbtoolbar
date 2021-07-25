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
    * [Create Library Config File](#create-dbtoolbar-config-file)
    * [Edit Toolbar](#edit-toolbar)
      * [Add Collectors Property](#i-add-item-to-collectors-property)
      * [Add sqlCssTheme property (Optional)](#ii-add-sqlcsstheme-property)
  * [Configuration](#configuration)
    * [Library Config](#1-library-config)
    * [Disable Default Database Collector](#2-disable-default-database-collector)
    * [Change Highlighter StyleSheet](#3-change-highlighter-stylesheet)
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

* Create Library config named [DbToolbar.php](#create-dbtoolbar-config-file)
* Edit [Toolbar.php](#edit-toolbar)

### Create DbToolbar Config File

Creating DbToolbar config can be done via spark:

    php spark dbtoolbar:config

Or manually create `app/Config/dbtoolbar.php` file using;

```php
<?php 

namespace Config;

class DbToolbar extends \Nfaiz\DbToolbar\Config\DbToolbar
{
    /**
     * -------------------------------------------------------------
     * Collect Queries?
     * -------------------------------------------------------------
     * 
     * To enable/disable query collector
     * 
     * @var boolean
     */
    public $collect = true;

    /**
     * -------------------------------------------------------------
     * Tab Title
     * -------------------------------------------------------------
     * 
     * Tab title display
     * 
     * @var string
     */
    public $tabTitle = 'Queries';

    /**
     * -------------------------------------------------------------
     * Bottom Margin Between Queries
     * -------------------------------------------------------------
     * 
     * Value in px
     * 
     * @var int
     */
    public $boxMarginBottom = 4;
}
```

### Edit Toolbar
Open `app/Config/Toolbar.php` file.

#### i. Add Item to Collectors Property
Add `\Nfaiz\DbToolbar\Collectors\Database::class` to **$collectors** property


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

#### ii. Add sqlCssTheme property
Adding sqlCssTheme to change SQL highlighter is optional. If this property did not exist, it will use default stylesheet theme.

```php
public $sqlCssTheme = [
    'light' => 'default',
    'dark'  => 'dark'
];

```

Once library installation and setup config files are completed, refresh page to see the result.<br />


## Configuration


### 1. Library Config
To **configure** DbToolbar, open `app/Config/DbToolbar.php`. Change the value accordingly.

| Property | Description | Type | Default |
| --- | --- | --- | --- |
| $collect | To enable/disable DbToolbar collector | Bool | `true` |
| $tabTitle | Title to display at debug toolbar tab | String | `Queries` |
| $boxMarginBottom | Bottom Margin Between Queries In px | Integer | `4` |



### 2. Disable Default Database Collector
To **disable** default database collector open `app/Config/Events.php` and then `comment` or `remove` code below;

```php
Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
```

### 3. Change Highlighter StyleSheet
To **change** highlighter stylesheet, open `app/Config/Toolbar.php`.

Find `$sqlCssTheme` property.

* Assign stylesheet name without `.css` extension to `light` or `dark` mode. E.g `'github'`
* Available stylesheets can be found using HighlightUtilities. Please see [highlighter-utilities](https://github.com/scrivo/highlight.php#highlighter-utilities) for more information.


E.g Using `\HighlightUtilities` in **Controller**

```php
    // Get available stylesheets.
    $availableStyleSheets = \HighlightUtilities\getAvailableStyleSheets();
    d($availableStyleSheets);

    // Set true to get available stylesheets with absolute path.
    $availableStyleSheetsPath = \HighlightUtilities\getAvailableStyleSheets(true);
    d($availableStyleSheetsPath);

    // Get specific stylesheet path.
    $sytleSheetPath = \HighlightUtilities\getStyleSheetPath('github');
    d($sytleSheetPath);
```

## Screenshot
Screenshot below are using `Database` for [tab title](#1-library-config) and default database toolbar is [disabled](#2-disable-default-database-collector)

### Default Database Toolbar

* Light<br />
<img src="https://user-images.githubusercontent.com/1330109/125154813-894c0b80-e18e-11eb-8bf3-4e6834437ad9.png" alt="Light mode">

* Dark<br />
<img src="https://user-images.githubusercontent.com/1330109/125154888-ef389300-e18e-11eb-88f6-7f066ec09775.png" alt="Dark mode">

### After using highlighter

* Light (using default.css)<br />
<img src="https://user-images.githubusercontent.com/1330109/125154946-450d3b00-e18f-11eb-982f-93fcc3d09e06.png" alt="Light mode">

* Dark (using dark.css)<br />
<img src="https://user-images.githubusercontent.com/1330109/125155349-bf3ebf00-e191-11eb-922f-8b9bd9f12df8.png" alt="Dark mode">

### Another example

* Light (using atom-one-light.css)
<img src="https://user-images.githubusercontent.com/1330109/125155187-bb5e6d00-e190-11eb-91a5-b4c2f7da46e4.png" alt="Light mode">

* Dark (using atom-one-dark.css)
<img src="https://user-images.githubusercontent.com/1330109/125155379-fca34c80-e191-11eb-981f-8fb6e8df9794.png" alt="Dark mode">

## Credit
- [Highlight.php](https://github.com/scrivo/highlight.php)
- Inspired by this [pull request](https://github.com/codeigniter4/CodeIgniter4/pull/3515)