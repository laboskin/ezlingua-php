<?php


namespace app\controllers;


use app\models\Course;
use app\models\forms\UserContactsChangeForm;
use app\models\forms\UserPasswordChangeForm;
use app\models\Language;
use app\models\UserVocabulary;
use app\models\UserWord;
use app\models\VocabularyWord;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
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

    public function actionSettings()
    {
        $userPasswordChange = new UserPasswordChangeForm();
        $userContactsChange = new UserContactsChangeForm();
        if($userContactsChange->load(Yii::$app->request->post())){
            if ($userContactsChange->validate())
                if ($userContactsChange->changeContacts())
                    return $this->refresh();
        }
        if($userPasswordChange->load(Yii::$app->request->post())){
            if ($userPasswordChange->validate())
                if ($userPasswordChange->changePassword())
                    return $this->refresh();
        }
        return $this->render('settings', ['userPasswordChange'=>$userPasswordChange, 'userContactsChange'=>$userContactsChange ]);
    }

    public function actionAddCourse()
    {
        $user = Yii::$app->user->getIdentity();
        $userCoursesIds = array_merge([$user->course_id], ArrayHelper::getColumn($user->getOtherCourses(), 'id'));
        $courses = Course::find()
            ->where(['original_language_id'=>$user->getCourse()->original_language_id])
            ->all();
        $courses = ArrayHelper::toArray($courses);
        foreach ($courses as $index=>$course)
            $courses[$index]['image'] = Language::findOne($course['goal_language_id'])->translation_code.'.png';
        $userLanguage = Language::findOne($courses[0]['original_language_id'])->name;
        return $this->render('add-course', [
            'courses' => $courses,
            'userCoursesIds' => $userCoursesIds,
            'userLanguage' => $userLanguage
        ]);
    }

    public function actionLogout()
    {
        if (!Yii::$app->user->isGuest)
            Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionChangeCourse($course_id)
    {
        $user = Yii::$app->user->getIdentity();
        $user->course_id = $course_id;
        $user->save();
        return $this->goBack();
    }

    public function actionDeleteWord($id)
    {
        UserWord::find()->where(['user_id' => Yii::$app->user->getId()])
                        ->andWhere(['word_id' => $id])
                        ->one()
                        ->delete();
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }


}