<?php

namespace app\modules\manajerkeuangan\controllers;

use app\helpers\TimeHelper;
use yii\web\Controller;
use app\models\db\Akun;
use app\modules\manajerkeuangan\models\form\LaporanKeuanganForm;


class LaporankeuanganController extends BaseController
{
    public function actionIndex($jenis = 'neraca')
    {
        $searchModel = new LaporanKeuanganForm;
        $searchModel->tanggal_awal = TimeHelper::getBeginningYear(TimeHelper::getTodayDate());
        $searchModel->tanggal_akhir = TimeHelper::getTodayDate();
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
