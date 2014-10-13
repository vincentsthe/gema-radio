<?php

namespace app\modules\adminradio\controllers;

use yii\web\Controller;
use app\models\db\Siaran;
use app\models\db\Rekaman;
use yii\data\ActiveDataProvider;



class NotifikasiController extends BaseController
{
	/**
	 * @param int $duration in seconds. default to 24 hours.
	 */
    public function actionSiaran($duration = 86400)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Siaran::queryToday($duration),
        ]);

        return $this->render('siaran', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
	 * @param int $duration in seconds. default to 24 hours.
	 */
    public function actionRekaman($duration = 86400)
    {
    	$dataProvider = new ActiveDataProvider([
    		'query' => Rekaman::queryToday($duration)
    	]);

    	return $this->render('rekaman',[
    		'dataProvider' => $dataProvider
    	]);
    }
}
