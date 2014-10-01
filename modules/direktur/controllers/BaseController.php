<?php
namespace app\modules\direktur\controllers;

use yii\filters\AccessControl;
use app\models\db\User;
use Yii;

abstract class BaseController extends \yii\web\Controller {

	public function behaviors(){
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
						'matchCallback' => function($rule,$action){
							if (isset(Yii::$app->user->identity))
								return Yii::$app->user->identity->isDirektur();
							else
								return false;
						}		
					],
					[
						'allow' => false,
						'roles' => ['@','?'],
					],
				]
			]
		];
	}
}

?>