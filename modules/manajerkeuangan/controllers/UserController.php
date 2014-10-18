<?php

namespace app\modules\manajerkeuangan\controllers;

use app\models\db\User;
use app\models\search\UserSearch;
use Yii;

class UserController extends BaseController
{
    public function behaviours() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    /**
     * Create new user
     * if success, redirect to index. if fail, repeat action
     */
    public function actionCreate()
    {
        $model = new User('register');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect(['index']);
        }

        return $this->render('create',[
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        User::findOne($id)->one()->delete();
        return $this->redirect(['index']);
    }
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

}
