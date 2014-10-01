<?php

namespace app\modules\adminradio\controllers;

use yii\web\Controller;

class NotifikasiController extends BaseController
{
    public function actionSiaran()
    {
        return $this->render('siaran');
    }

    public function actionRekaman()
    {
    	return $this->render('rekaman');
    }
}
