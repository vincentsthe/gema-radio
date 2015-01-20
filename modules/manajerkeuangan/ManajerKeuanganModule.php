<?php

namespace app\modules\manajerkeuangan;

class ManajerKeuanganModule extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\manajerkeuangan\controllers';
    public $defaultRoute = 'manajerkeuangan/transaksi/listtransaction';
    
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
