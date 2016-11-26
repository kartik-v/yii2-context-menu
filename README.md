yii2-context-menu
=================

[![Stable Version](https://poser.pugx.org/kartik-v/yii2-context-menu/v/stable)](https://packagist.org/packages/kartik-v/yii2-context-menu)
[![Unstable Version](https://poser.pugx.org/kartik-v/yii2-context-menu/v/unstable)](https://packagist.org/packages/kartik-v/yii2-context-menu)
[![License](https://poser.pugx.org/kartik-v/yii2-context-menu/license)](https://packagist.org/packages/kartik-v/yii2-context-menu)
[![Total Downloads](https://poser.pugx.org/kartik-v/yii2-context-menu/downloads)](https://packagist.org/packages/kartik-v/yii2-context-menu)
[![Monthly Downloads](https://poser.pugx.org/kartik-v/yii2-context-menu/d/monthly)](https://packagist.org/packages/kartik-v/yii2-context-menu)
[![Daily Downloads](https://poser.pugx.org/kartik-v/yii2-context-menu/d/daily)](https://packagist.org/packages/kartik-v/yii2-context-menu)

A context menu extension for Yii framework 2.0 that allows you to add and render a context menu to any element on the page. A context menu 
is a pop up menu that one initiates on any element by right clicking the mouse in that target element. This widget is a wrapper for the 
[bootstrap-contextmenu plugin](https://github.com/sydcanem/bootstrap-contextmenu) which is styled for Bootstrap 3. The widget uses 
the `\yii\bootstrap\Dropdown` widget to generate a dropdown menu.

### Demo
You can see detailed [documentation](http://demos.krajee.com/context-menu) on usage of the extension.

## Latest Release
The latest version of the module is v1.2.2 released. Refer the [CHANGE LOG](https://github.com/kartik-v/yii2-context-menu/blob/master/CHANGE.md) for details.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

> Note: Check the [composer.json](https://github.com/kartik-v/yii2-context-menu/blob/master/composer.json) for this extension's requirements and dependencies. Read this [web tip /wiki](http://webtips.krajee.com/setting-composer-minimum-stability-application/) on setting the `minimum-stability` settings for your application's composer.json.

Either run

```
$ php composer.phar require kartik-v/yii2-context-menu "dev-master"
```

or add

```
"kartik-v/yii2-context-menu": "dev-master"
```

to the ```require``` section of your `composer.json` file.

## Usage

### ContextMenu

```php
use kartik\cmenu\ContextMenu;
ContextMenu::begin([
    'items' => [
        ['label' => 'Action', 'url' => '#'],
        ['label' => 'Another action', 'url' => '#'],
        ['label' => 'Something else here', 'url' => '#'],
        '<li class="divider"></li>',
        ['label' => 'Separated link', 'url' => '#'],
    ],
]); 
// fill in any content within your target container
ContextMenu::end();
```

## License

**yii2-context-menu** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.