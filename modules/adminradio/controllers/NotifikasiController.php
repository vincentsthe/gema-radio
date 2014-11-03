<?php

namespace app\modules\adminradio\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\helpers\TimeHelper;
use app\models\db\Siaran;
use app\models\db\Rekaman;
use yii\data\ActiveDataProvider;
use yii\web\Session;
use yii\helpers\ArrayHelper;

const DURATION_SESSION_KEY = 'adminradio.notifikasi.durasi';

class NotifikasiController extends BaseController
{
	public $defaultAction = 'siaran';
	public $_session;

	public function behaviors(){
		return ArrayHelper::merge([
			//allow access to direktur
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
						'matchCallback' => function($rule,$action){
							if (isset(Yii::$app->user->identity)){
								return Yii::$app->user->identity->isDirektur();
							}
							else
								return false;
						}		
					],
				]
			]
		],parent::behaviors());
	}
	/**
	 */
    public function actionSiaran()
    {
    	if(Yii::$app->request->isPost) {
    		Yii::$app->response->format = 'json';

    		if(Yii::$app->request->post('request') == "deskripsi") {
    			$id = Yii::$app->request->post('id');
    			return Siaran::findOne($id)->transaksi->deskripsi;
    		} else if(Yii::$app->request->post('request') == "change") {
    			$id = Yii::$app->request->post('id');
    			$siaran = Siaran::findOne($id);
    			$siaran->checked = Yii::$app->request->post('checked');
    			$siaran->save();
    			return "success";
    		} else if(Yii::$app->request->post('request') == "status") {
    			$id = Yii::$app->request->post('id');
    			return Siaran::findOne($id)->checked;
    		} else if(Yii::$app->request->post('request') == "jam") {
    			$jam = (int)substr(TimeHelper::getBeginningHourTime(), 0, 2);
    			return $jam;
    		}
    	}

        $listSiaran = Siaran::queryToday()->all();

        $list = array();
        for($i=(int)substr(TimeHelper::getBeginningHourTime(), 0, 2) ; $i<=23 ; $i++) {
        	$list[$i] = array();
        }

        foreach($listSiaran as $siaran) {
        	$list[(int)substr($siaran->waktu, 0, 2)][] = $siaran;
        }

        return $this->render('siaran', [
            'list' => $list,
        ]);
    }

    /**
	 */
    public function actionRekaman()
    {

    	if(Yii::$app->request->isPost) {
    		Yii::$app->response->format = 'json';

    		if(Yii::$app->request->post('request') == "deskripsi") {
    			$id = Yii::$app->request->post('id');
    			return Rekaman::findOne($id)->transaksi->deskripsi;
    		} else if(Yii::$app->request->post('request') == "change") {
    			$id = Yii::$app->request->post('id');
    			$siaran = Rekaman::findOne($id);
    			$siaran->checked = Yii::$app->request->post('checked');
    			$siaran->save();
    			return "success";
    		} else if(Yii::$app->request->post('request') == "status") {
    			$id = Yii::$app->request->post('id');
    			return Rekaman::findOne($id)->checked;
    		} else if(Yii::$app->request->post('request') == "jam") {
    			$jam = (int)substr(TimeHelper::getBeginningHourTime(), 0, 2);
    			return $jam;
    		}
    	}

        $listRekaman = Rekaman::queryToday()->all();

        $list = array();
        for($i=(int)substr(TimeHelper::getBeginningHourTime(), 0, 2) ; $i<=23 ; $i++) {
        	$list[$i] = array();
        }

        foreach($listRekaman as $rekaman) {
        	$list[(int)substr($rekaman->waktu, 0, 2)][] = $rekaman;
        }

        return $this->render('rekaman', [
            'list' => $list,
        ]);
    }

    public function beforeAction($action)
	{
	    if (parent::beforeAction($action)) {
	        $this->_session = new Session;
	        $this->_session->open();
	        if (!isset($this->_session[DURATION_SESSION_KEY])){
	        	$this->_session[DURATION_SESSION_KEY] = 5;
	        }
	        return true;
	    } else {
	        return false;
	    }
	}
}
