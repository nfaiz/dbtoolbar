# Manual

## Installation

* [Download and set autoload](#1-download-and-set-autoload)
* [Install Highlight.php](#2-install-highlightphp)

### 1. Download and set autoload
Download this library, extract and rename this folder to **ci4-dbtoolbar**.<br />
Enable it by editing **app/Config/Autoload.php** and adding the **Nfaiz\DbToolbar** namespace to the **$psr4** array.

E.g Using **app/ThirdParty** directory path:
```php
$psr4 = [
    APP_NAMESPACE     => APPPATH, // For custom app namespace
    'Config'          => APPPATH . 'Config',
    'Nfaiz\DbToolbar' => APPPATH . 'ThirdParty\ci4-dbtoolbar\src',
];
```
See [namespace](https://www.codeigniter.com/user_guide/general/modules.html#namespaces) for more information.

### 2. Install Highlight.php
Install package via composer:

    composer require scrivo/highlight.php:^v9.18


## Setup

In **app/Config** directory<br />

* Modify [Toolbar](#1-toolbar)
* Create [DbToolbar](#2-dbtoolbar)


### 1. Toolbar
Open `app/Config/Toolbar.php`<br />

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

#### ii. Add sqlCssTheme and sqlMarginBottom property
```php

public $sqlCssTheme = [
    'light' => 'default',
    'dark'  => 'dark'
];

public $sqlMarginBottom = 4;

```

### 2. DbToolbar
Create `app/Config/DbToolbar.php` file using;

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
}
```