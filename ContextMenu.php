<?php

/**
 * @package   yii2-context-menu
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013 - 2016
 * @version   1.2.2
 */
namespace kartik\cmenu;

use Yii;
use kartik\base\Widget;
use yii\bootstrap\Dropdown;
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
 *         '<li class="divider"></li>',
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
     * Name of the jQuery plugin used in rendering the [[ContextMenu]] widget.
     */
    const PLUGIN_NAME = 'contextmenu';

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
     * To insert a divider between dropdown list items use `<li role="presentation" class="divider"></li>`.
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
     * @var array HTML attributes for the context menu target container. The following special options
     * are recognized.
     * - `tag`: _string_, the tag for rendering the target container. Defaults to `span`.
     */
    public $options = [];

    /**
     * @var array the plugin options for bootstrap-contextmenu.
     * @see https://github.com/sydcanem/bootstrap-contextmenu
     */
    public $pluginOptions = [];

    /**
     * @var array the jQuery plugin events for bootstrap-contextmenu. You must define events as
     * `event-name => event-function`. For example:
     *
     * ```php
     * pluginEvents = [
     *     "change" => "function() { log("change"); }",
     *     "open" => "function() { log("open"); }",
     * ];
     * ```
     */
    public $pluginEvents = [];

    /**
     * @var string the hashed variable to store the pluginOptions
     */
    protected $_hashVar;

    /**
     * @var string the Json encoded options
     */
    protected $_encOptions = '';

    /**
     * @var string the dropdown menu container tag
     */
    private $_menuTag;

    /**
     * @var string the target container tag
     */
    private $_targetTag;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (empty($this->items) || !is_array($this->items)) {
            throw new InvalidConfigException("The 'items' property must be set as required in '\\yii\\bootstrap\\Dropdown'.");
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
        echo Dropdown::widget([
                'items' => $this->items,
                'encodeLabels' => $this->encodeLabels,
                'options' => $this->menuOptions
            ]) . PHP_EOL;
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
        $this->registerPlugin(self::PLUGIN_NAME);
    }

}