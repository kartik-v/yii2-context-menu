<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-context-menu
 * @version 1.2.0
 */

namespace kartik\cmenu;

use Yii;
use kartik\base\Widget;
use yii\bootstrap\Dropdown;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;

/**
 * A context menu extension for Bootstrap 3.0, which allows you to access
 * a context menu for a specific area on mouse right click.
 * Based on bootstrap-contextmenu jquery plugin by sydcanem.
 *
 * @see https://github.com/sydcanem/bootstrap-contextmenu
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class ContextMenu extends Widget
{
    const PLUGIN_NAME = 'contextmenu';

    /**
     * @var array list of menu items in the dropdown. Each array element can be either an HTML string,
     * or an array representing a single menu with the following structure:
     *
     * - label: string, required, the label of the item link
     * - url: string, optional, the url of the item link. Defaults to "#".
     * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item link.
     * - options: array, optional, the HTML attributes of the item.
     * - items: array, optional, the submenu items. The structure is the same as this property.
     *   Note that Bootstrap doesn't support dropdown submenu. You have to add your own CSS styles to support it.
     *
     * To insert divider use `<li role="presentation" class="divider"></li>`.
     */
    public $items = [];

    /**
     * @var boolean whether the labels for header items should be HTML-encoded.
     */
    public $encodeLabels = true;

    /**
     * @var array HTML attributes for the dropdown menu container. The following special options
     * are recognized.
     * - tag: string, the tag for rendering the dropdown menu container. Defaults to `div`.
     */
    public $menuContainer = [];

    /**
     * @var array HTML attributes for the dropdown menu UL tag
     * (options as required by [[yii\bootstrap\Dropdown]]
     */
    public $menuOptions;

    /**
     * @var array HTML attributes for the context menu target container. The following special options
     * are recognized.
     * - tag: string, the tag for rendering the target container. Defaults to `span`.
     */
    public $options = [];

    /**
     * @var array bootstrap-contextmenu plugin options
     * @see https://github.com/sydcanem/bootstrap-contextmenu
     */
    public $pluginOptions = [];

    /**
     * @var array widget JQuery events. You must define events in
     * event-name => event-function format
     * for example:
     * ~~~
     * pluginEvents = [
     *        "change" => "function() { log("change"); }",
     *        "open" => "function() { log("open"); }",
     * ];
     * ~~~
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
     * Initializes the widget
     *
     * @throws \yii\base\InvalidConfigException
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
     * Runs the widget
     *
     * @return string|void
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
     * Registers widget assets
     */
    protected function registerAssets()
    {
        $view = $this->getView();
        ContextMenuAsset::register($view);
        $this->registerPlugin(self::PLUGIN_NAME);
    }

}