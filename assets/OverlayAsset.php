<?php

namespace app\assets;

use yii\web\AssetBundle;

class OverlayAsset extends AssetBundle {
	public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    	'css/overlay.css'
    ];
    public $js = [
        'js/overlay.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}