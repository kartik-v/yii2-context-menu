<?php

/**
 * @package   yii2-context-menu
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013 - 2020
 * @version   1.2.3
 */
namespace kartik\cmenu;

use kartik\base\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;

/**
 * ContextMenu widget allows to access a bootstrap styled context menu on a specific element on the page via the mouse
 * right click. This is based on bootstrap-contextmenu jquery plugin by sydcanem.
 *
 * Usage example:
 *
 * ~~~
 * use kartik\cmenu\ContextMenu;
 * ContextMenu::begin([
 *     'items' => [
 *         ['label' => 'Action', 'url' => '#'],
 *         ['label' => 'Another action', 'url' => '#'],
 *         ['label' => 'Something else here', 'url' => '#'],
 *         '<div class="dropdown-divider"></div>',
 *         ['label' => 'Separated link', 'url' => '#'],
 *     ],
 * ]);
 * // fill in any content within your target container
 * ContextMenu::end();
 * ~~~
 *
 * @see https://github.com/sydcanem/bootstrap-contextmenu
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class ContextMenu extends Widget
{
    /**
     * @inheritdoc
     */
    public $pluginName = 'contextmenu';

    /**
     * @var array list of menu items in the dropdown. Each array element can be either an HTML string,
     * or an array representing a single menu with the following structure:
     *
     * - `label`: _string_, required_, the label of the item link
     * - `url`: _string_, optional_, the url of the item link. Defaults to "#".
     * - `visible`: _boolean_, optional_, whether this menu item is visible. Defaults to true.
     * - `linkOptions`: _array_, optional_, the HTML attributes of the item link.
     * - `options`: _array_, optional_, the HTML attributes of the item.
     * - `items`: _array_, optional_, the submenu items. The structure is the same as this property. Note that Bootstrap
     *    does not support dropdown submenu. You have to add your own CSS styles to support it.
     *
     * To insert a divider between dropdown list items use:
     * - `<div role="presentation" class="dropdown-divider"></div>` for Bootstrap 4.x
     * - `<li role="presentation" class="divider"></li>` for Bootstrap 3.x
     */
    public $items = [];

    /**
     * @var boolean whether the labels for header items should be HTML-encoded.
     */
    public $encodeLabels = true;

    /**
     * @var array HTML attributes for the dropdown menu container. The following special options are recognized:
     * - `tag`: _string_, the tag for rendering the dropdown menu container. Defaults to `div`.
     */
    public $menuContainer = [];

    /**
     * @var array HTML attributes for the dropdown menu UL tag (options as required by [[Dropdown]]
     */
    public $menuOptions;

    /**
     * @var string the dropdown menu container tag
     */
    private $_menuTag;

    /**
     * @var string the target container tag
     */
    private $_targetTag;

    /**
     * @var string the dropdown 
     */
    protected $_dropdownClass; 

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $class = $this->_dropdownClass = $this->isBs4() ? '\kartik\bs4dropdown\Dropdown' : '\yii\bootstrap\Dropdown';
        if (!class_exists($class)) {
            throw new InvalidConfigException("The required dropdown class '{$class}' is not installed or invalid.");
        }
        if (empty($this->items) || !is_array($this->items)) {
            throw new InvalidConfigException("The 'items' property must be set as required in '{$class}'.");
        }
        $this->initOptions();
        $this->registerAssets();
        echo Html::beginTag($this->_targetTag, $this->options) . PHP_EOL;
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo Html::endTag($this->_targetTag) . PHP_EOL;
        echo Html::beginTag($this->_menuTag, $this->menuContainer) . PHP_EOL;
        /**
         * @var Widget $class
         */
        $class = $this->_dropdownClass;
        $opts = [
            'items' => $this->items,
            'encodeLabels' => $this->encodeLabels,
            'options' => $this->menuOptions
        ];
        echo $class::widget($opts) . PHP_EOL;
        echo Html::endTag($this->_menuTag);
    }

    /**
     * Initializes the widget options
     */
    protected function initOptions()
    {
        $id = $this->options['id'];
        if (empty($this->menuContainer['id'])) {
            $this->menuContainer['id'] = "{$id}-menu";
        }
        if (empty($this->menuOptions['id'])) {
            $this->menuOptions['id'] = "{$id}-menu-list";
        }
        $this->pluginOptions['isBs4'] = $this->isBs4();
        $this->pluginOptions['target'] = '#' . $this->menuContainer['id'];
        if (!empty($this->pluginOptions['before']) && !$this->pluginOptions['before'] instanceof JsExpression) {
            $this->pluginOptions['before'] = new JsExpression($this->pluginOptions['before']);
        }
        if (!empty($this->pluginOptions['onItem']) && !$this->pluginOptions['onItem'] instanceof JsExpression) {
            $this->pluginOptions['onItem'] = new JsExpression($this->pluginOptions['onItem']);
        }
        $this->_targetTag = ArrayHelper::remove($this->options, 'tag', 'span');
        $this->_menuTag = ArrayHelper::remove($this->menuContainer, 'tag', 'div');
    }

    /**
     * Registers client assets for [[ContextMenu]] widget.
     */
    protected function registerAssets()
    {
        $view = $this->getView();
        ContextMenuAsset::register($view);
        $this->registerPlugin($this->pluginName);
    }

}