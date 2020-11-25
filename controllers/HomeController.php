<?php


namespace app\controllers;


use app\components\LanguageSelector;
use app\models\Course;
use app\models\forms\HomeResetForm;
use app\models\forms\HomeRestoreForm;
use app\models\forms\LoginForm;
use app\models\forms\RegisterForm;
use app\models\Language;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\Response;
use yii\widgets\ActiveForm;

class HomeController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'register'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        if(!Yii::$app->user->isGuest)
            return $this->redirect(['dictionary/']);
        if(Yii::$app->request->getUrl() != '/')
            return $this->goHome();
        $this->layout = 'homepage';
        return $this->render('index', [
        ]);
    }

    public function actionRegister()
    {
        if(!Yii::$app->user->isGuest)
            return $this->redirect(['training/']);
        $this->layout = 'homepage';
        $model = new RegisterForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if (!Yii::$app->request->isAjax and $model->load(Yii::$app->request->post()))
            if ($model->validate() && $model->register())
                return $this->redirect(['dictionary/']);
        return $this->render('register', [
            'model' => $model
        ]);
    }

    public function actionLogin()
    {
        if(!Yii::$app->user->isGuest)
            return $this->redirect(['training/']);
        $this->layout = 'homepage';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $user = $model->getUser();
              Yii::$app->response->cookies->add(new Cookie([
                'name' => 'language',
                'value' => Language::findOne(Course::findOne($user->course_id)->original_language_id)->yii_code,
                'expire' => time() + 60*60*24*365 // 1 year
              ]));
                Yii::$app->user->login($user, 3600*24*30*12);
                return $this->redirect(['dictionary/']);
            }
        }
        return $this->render('login', [
            'model' => $model
        ]);
    }

    public function actionRestore()
    {
        if(!Yii::$app->user->isGuest)
            return $this->redirect(['training/']);
        $this->layout = 'homepage';
        $model = new HomeRestoreForm();
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->sendMail())
            return $this->goHome();
        return $this->render('restore', ['model'=>$model]);
    }

    public function actionReset($key)
    {
        if(!Yii::$app->user->isGuest)
            return $this->redirect(['training/']);
        $this->layout = 'homepage';
        $model = new HomeResetForm($key);
        if($model->error)
            return $this->goHome();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->resetPassword()) {
                return $this->goHome();
            }
        }
        return $this->render('reset', [
            'model' => $model,
        ]);
    }

    public function actionAjaxChangeLanguage($id)
    {
        if(Yii::$app->request->isAjax and Yii::$app->user->isGuest)
        {
            $language = Language::findOne($id);
            if (in_array($language->yii_code, LanguageSelector::$languages))
                Yii::$app->response->cookies->add(new Cookie([
                    'name' => 'language',
                    'value' => $language->yii_code,
                    'expire' => time() + 60*60*24*365 // 1 year
                ]));
        }
        return true;
    }
}