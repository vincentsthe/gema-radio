<?php

namespace app\modules\manajerkeuangan\controllers;

use yii\web\Controller;
use app\models\db\Akun;

class LaporankeuanganController extends BaseController
{
    public function actionIndex($jenis = 'neraca')
    {
        if ($jenis == 'neraca'){
            $rootAkuns = Akun::findNeraca()->all();
        } else {
            $rootAkuns = Akun::findLabaRugi()->andWhere(['parent' => 0])->all();
        }

        foreach($rootAkuns as $rootAkun) {
            $rootAkun->updateHarga();
        }

        return $this->render('index',[
        	'rootAkuns' => $rootAkuns,
        ]);
    }

    public function actionUpdate()
    {
    	Akun::updateAllHarga();
    	//return $this->redirect('index');
    }

}
