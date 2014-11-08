<?php

namespace app\assets;

use yii\web\AssetBundle;

class PrintAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/html2canvas.js',
        'js/jspdf.min.js',
    ];
    public $depends = [
        'app\assets\AppAsset',
    ];
}
