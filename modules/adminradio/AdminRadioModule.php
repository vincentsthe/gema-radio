<?php


namespace app\modules\adminradio;

use Yii;
class AdminRadioModule extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\adminradio\controllers';
    public $defaultRoute = 'notifikasi/siaran';
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
