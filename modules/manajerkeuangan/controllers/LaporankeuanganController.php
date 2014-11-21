<?php

namespace app\modules\manajerkeuangan\controllers;

use yii\web\Controller;
use app\models\db\Akun;
use app\modules\manajerkeuangan\models\form\LaporanKeuanganForm;


class LaporankeuanganController extends BaseController
{
    public function actionIndex($jenis = 'neraca')
    {
        $searchModel = new LaporanKeuanganForm;
        $searchModel->tanggal_awal = '2014-01-01';
        $searchModel->tanggal_akhir = '2014-01-01';
        if ($searchModel->load(\Yii::$app->request->get()) && $searchModel->validate()) {
        }

        if ($jenis == 'neraca'){
            $rootAkuns = Akun::findNeraca()->all();
        } else {
            $rootAkuns = Akun::findLabaRugi()->andWhere(['parent' => 0])->all();
        }

        foreach($rootAkuns as $rootAkun) {
            $rootAkun->updateHarga($searchModel->tanggal_awal,$searchModel->tanggal_akhir);
        }
        return $this->render('index',[
         	'rootAkuns' => $rootAkuns,
             'searchModel' => $searchModel,
             'jenis' => $jenis
         ]);
    }

    public function actionUpdate()
    {
    	Akun::updateAllHarga();
    	return $this->redirect('index');
    }

}
