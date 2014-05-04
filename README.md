yii2-context-menu
=================

A context menu extension for Yii framework 2.0 based on the [bootstrap-contextmenu plugin](https://github.com/sydcanem/bootstrap-contextmenu) 
styled for Bootstrap 3.

## ContextMenu

`\kartik\cmenu\ContextMenu`

### Demo
You can see detailed [documentation](http://demos.krajee.com/context-menu) on usage of the extension.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

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