<?php

/**
 * @package   yii2-context-menu
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013 - 2016
 * @version   1.2.1
 */
namespace kartik\cmenu;

/**
 * ContextMenu bundle for \kartik\cmenu\ContextMenu
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since  1.0
 */
class ContextMenuAsset extends \kartik\base\AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('js', ['js/bootstrap-contextmenu']);
        parent::init();
    }

}