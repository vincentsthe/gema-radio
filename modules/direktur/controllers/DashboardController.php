<?php

namespace app\modules\direktur\controllers;

class DashboardController extends BaseController
{
	public $defaultAction = 'Bukubesar';

	public function actionNotifikasi(){
		$this->redirect(['/adminradio/notifikasi']);
	}

    public function actionBukubesar()
    {
        $this->redirect(['/manajerkeuangan/bukubesar']);
    }

    public function actionLaporankeuangan(){
    	$this->redirect(['/manajerkeuangan/laporankeuangan']);
    }

    public function actionTabungantua(){
    	$this->redirect(['/manajerkeuangan/tabungantua']);
    }

    public function actionKonfigurasiPengguna(){
    	$this->redirect(['/manajerkeuangan/konfigurasipengguna']);
    }
}
