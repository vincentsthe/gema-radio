<?php

namespace app\assets;

use yii\web\AssetBundle;

class SiaranAsset extends AssetBundle {
	public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/siaran.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\OverlayAsset',
    ];
}