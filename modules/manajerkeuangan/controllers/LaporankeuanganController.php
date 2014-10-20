<?php

namespace app\modules\manajerkeuangan\controllers;

use yii\web\Controller;
use app\models\db\Akun;

class LaporankeuanganController extends BaseController
{
    public function actionIndex()
    {
        $rootAkuns = Akun::find()->where(['parent' => 0])->all();
        foreach($rootAkuns as $rootAkun) {
            $rootAkun->updateHarga();
        }

        return $this->render('index',[
        	'rootAkuns' => Akun::find()->where(['parent'=>0])->all()
        ]);
    }

    public function actionUpdate()
    {
    	Akun::updateAllHarga();
    	//return $this->redirect('index');
    }

}
