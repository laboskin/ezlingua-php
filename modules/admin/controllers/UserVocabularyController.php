<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\UserVocabulary;
use app\modules\admin\models\UserVocabularySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserVocabularyController implements the CRUD actions for UserVocabulary model.
 */
class UserVocabularyController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if(!Yii::$app->user->isGuest and \app\models\User::findOne(Yii::$app->user->id)->status == \app\models\User::STATUS_ADMIN)
        {
            $searchModel = new UserVocabularySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        else
            return $this->goHome();
    }

    public function actionView($id)
    {
        if(!Yii::$app->user->isGuest and \app\models\User::findOne(Yii::$app->user->id)->status == \app\models\User::STATUS_ADMIN)
        {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
        else
            return $this->goHome();
    }

    public function actionCreate()
    {
        if(!Yii::$app->user->isGuest and \app\models\User::findOne(Yii::$app->user->id)->status == \app\models\User::STATUS_ADMIN)
        {
            $model = new UserVocabulary();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        else
            return $this->goHome();
    }

    public function actionUpdate($id)
    {
        if(!Yii::$app->user->isGuest and \app\models\User::findOne(Yii::$app->user->id)->status == \app\models\User::STATUS_ADMIN)
        {
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        else
            return $this->goHome();
    }

    public function actionDelete($id)
    {
        if(!Yii::$app->user->isGuest and \app\models\User::findOne(Yii::$app->user->id)->status == \app\models\User::STATUS_ADMIN)
        {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }
        else
            return $this->goHome();
    }

    /**
     * Finds the UserVocabulary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserVocabulary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserVocabulary::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
