<?php

namespace app\modules\direktur\controllers;

class DashboardController extends BaseController
{
	public $defaultAction = 'Bukubesar';
    public function actionBukubesar()
    {
        return $this->render('bukubesar');
    }

}
