<?php

namespace app\modules\manajerkeuangan\controllers;

use yii\web\Controller;

class DashboardController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
