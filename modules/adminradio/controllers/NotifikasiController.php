<?php

namespace app\modules\adminradio\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
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
	 * @param int $duration in minutes. default to 24 hours.
	 */
    public function actionSiaran($duration = null)
    {
    	if ($duration !== null){
    		$this->_session[DURATION_SESSION_KEY] = $duration;
    	} else {
    		$duration = $this->_session[DURATION_SESSION_KEY];
    	}

        $dataProvider = new ActiveDataProvider([
            'query' => Siaran::queryToday($this->_session[DURATION_SESSION_KEY]),
        ]);

        return $this->render('siaran', [
            'dataProvider' => $dataProvider,
            'duration' => $duration
        ]);
    }

    /**
	 * @param int $duration in minutes. default to 24 hours.
	 */
    public function actionRekaman($duration = null)
    {
    	if ($duration !== null){
    		$this->_session[DURATION_SESSION_KEY] = $duration;
    	} else {
    		$duration = $this->_session[DURATION_SESSION_KEY];
    	}

    	$dataProvider = new ActiveDataProvider([
    		'query' => Rekaman::queryToday($this->_session[DURATION_SESSION_KEY])
    	]);

    	return $this->render('rekaman',[
    		'dataProvider' => $dataProvider,
    		'duration' => $duration
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
