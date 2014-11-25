<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-context-menu
 * @version 1.2.0
 */

namespace kartik\cmenu;

/**
 * ContextMenu bundle for \kartik\cmenu\ContextMenu
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class ContextMenuAsset extends \kartik\base\AssetBundle
{

    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('js', ['js/bootstrap-contextmenu']);
        parent::init();
    }

}