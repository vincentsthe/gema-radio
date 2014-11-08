<?php

namespace app\assets;

use yii\web\AssetBundle;

class RekamanAsset extends AssetBundle {
	public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/rekaman.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\OverlayAsset',
    ];
}