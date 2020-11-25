<?php


namespace app\controllers;


use app\components\LanguageSelector;
use app\models\Course;
use app\models\forms\DictionaryNewForm;
use app\models\forms\DictionaryNewGroupForm;
use app\models\forms\DictionaryNewWordForm;
use app\models\Language;
use app\models\User;
use app\models\UserVocabulary;
use app\models\UserWord;
use app\models\Vocabulary;
use app\models\VocabularyGroup;
use app\models\VocabularyWord;
use app\models\Word;
use Yii;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\UploadedFile;
use yii2mod\query\ArrayQuery;

class DictionaryController extends Controller
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

    public function actionIndex()
    {
        if (!Yii::$app->request->isPjax)
        {
            $user = Yii::$app->user->getIdentity();
            $userwords = UserWord::find()
                ->where(['user_id' => $user->id])
                ->andWhere(['in', 'word_id', ArrayHelper::getColumn(Word::find()->where(['course_id'=>$user->course_id])->select('id')->all(), 'id')])
                ->all();
            $userwords = ArrayHelper::toArray($userwords, [
                'app\models\UserWord' => [
                    'word_id',
                    'vocabulary_id',
                    'trainingStatus'
                ]
            ]);
            $userwords = ArrayHelper::index($userwords, 'word_id');
            $vocabularyGroups = ArrayHelper::index(VocabularyGroup::find()
                ->where(['course_id' => $user->course_id])
                ->asArray()
                ->all(), 'id');
            $vocabularies = ArrayHelper::index(ArrayHelper::toArray(Vocabulary::find()
                ->where(['course_id' => $user->course_id])
                ->all(), [
                    'app\models\Vocabulary' =>
                    [
                        'id',
                        'name',
                        'course_id',
                        'group_id',
                        'image',
                        'imageLink'
                    ]
            ]), 'id');
            foreach ($vocabularies as $index=>$vocabulary)
            {
                $vocabularies[$index]['count'] = 0;
                $vocabularies[$index]['wordIds'] = [];
            }
            $userVocabularyIds = ArrayHelper::getColumn(UserVocabulary::find()->where(['user_id'=>$user->id])->all(), 'vocabulary_id');
            $vocabularyWords = VocabularyWord::find()
                ->where(['in', 'vocabulary_id', ArrayHelper::getColumn($vocabularies, 'id')])
                ->asArray()
                ->all();
            foreach ($vocabularyWords as $vocabularyWord)
            {
                $vocabularies[$vocabularyWord['vocabulary_id']]['count']++;
                $vocabularies[$vocabularyWord['vocabulary_id']]['wordIds'][] = $vocabularyWord['word_id'];
            }
        }
        else
        {
            $userwords = json_decode(Yii::$app->request->post('userwords'), true);
            $vocabularyGroups = json_decode(Yii::$app->request->post('vocabularyGroups'), true);
            $vocabularies = json_decode(Yii::$app->request->post('vocabularies'), true);
            $userVocabularyIds = json_decode(Yii::$app->request->post('userVocabularyIds'), true);
            if(Yii::$app->request->post('addVocabulary'))
            {
                $vocabularyId = Yii::$app->request->post('vocabularyId');
                $userVocabularyIds[] = $vocabularyId;
                foreach ($vocabularies[$vocabularyId]['wordIds'] as $wordId)
                {
                    $newWord = true;
                    if (isset($userwords[$wordId]) and $userwords[$wordId]['vocabulary_id'] == $vocabularyId)
                    {
                        $userwords[$wordId]['trainingStatus'] = UserWord::TRAINING_STATUS_NEW;
                        $newWord = false;
                    }
                    if ($newWord)
                    {
                        $tempUserWord = [];
                        $tempUserWord['word_id'] = $wordId;
                        $tempUserWord['vocabulary_id'] = $vocabularyId;
                        $tempUserWord['trainingStatus'] = UserWord::TRAINING_STATUS_NEW;
                        $userwords[] = $tempUserWord;
                    }
                }
            }
            elseif(Yii::$app->request->post('removeVocabulary'))
            {
                $vocabularyId = Yii::$app->request->post('vocabularyId');
                unset($userVocabularyIds[array_search($vocabularyId, $userVocabularyIds)]);
                foreach ($userwords as $index=>$userword)
                    if($userword['vocabulary_id'] == $vocabularyId)
                        unset($userwords[$index]);
            }
        }
        return $this->render('index', [
            'userwords' => $userwords,
            'vocabularyGroups' => $vocabularyGroups,
            'vocabularies' => $vocabularies,
            'userVocabularyIds' => $userVocabularyIds,
        ]);
    }

    public function actionMy()
    {
        if(!Yii::$app->request->isPjax)
        {
            $user = Yii::$app->user->getIdentity();
            if(Yii::$app->request->get('v') != -1 and Yii::$app->request->get('v') and UserVocabulary::find()
                    ->where(['vocabulary_id'=>Yii::$app->request->get('v')])
                    ->andWhere(['user_id' => $user->id])
                    ->one() == null)
                return $this->redirect(['dictionary/my']);
            $userWordQuery = UserWord::find()->where(['user_id'=>$user->id]);
            if (Yii::$app->request->get('v'))
                $userWordQuery = $userWordQuery->andWhere(['vocabulary_id' => Yii::$app->request->get('v')]);
            $userWordArray = ArrayHelper::toArray($userWordQuery->all(), [
                'app\models\UserWord' => [
                    'id',
                    'word_id',
                    'vocabulary_id',
                    'training_word_translation',
                    'training_translation_word',
                    'training_cards',
                    'training_constructor',
                    'training_audio',
                    'trainingStatus'
                ]
            ]);
            $vocabularies = ArrayHelper::toArray(Vocabulary::find()
                ->where(['course_id' => $user->course_id])
                ->all(), [
                'app\models\Vocabulary' =>
                    [
                        'id',
                        'name',
                        'course_id',
                        'group_id',
                        'image',
                        'imageLink'
                    ]
            ]);
            $vocabularies[-1] = [];
            $vocabularies[-1]['name'] = Yii::t('dictionaryMy', 'Words from content');
            $vocabularies[-1]['id'] = -1;
            $vocabularies[-1]['image'] = 'content.png';
            $vocabularies = ArrayHelper::index($vocabularies, 'id');
            $words = Word::find()
                ->where(['course_id' => $user->course_id])
                ->andWhere(['in', 'id', ArrayHelper::getColumn($userWordArray, 'word_id')])
                ->asArray()
                ->select(['id', 'original', 'translation'])
                ->all();
            $words = ArrayHelper::index($words, 'id');
            $sortWords = [];
            foreach (array_reverse($userWordArray) as $userword)
                if (isset($words[$userword['word_id']]))
                {
                    $sortWords[$userword['id']] = $words[$userword['word_id']];
                    $sortWords[$userword['id']]['userword_id'] = $userword['id'];
                    $sortWords[$userword['id']]['vocabulary_id'] = $userword['vocabulary_id'];
                    $sortWords[$userword['id']]['vocabulary_name'] = $vocabularies[$userword['vocabulary_id']]['name'];
                    $sortWords[$userword['id']]['trainingStatus'] = $userword['trainingStatus'];
                    $sortWords[$userword['id']]['training_word_translation'] = $userword['training_word_translation'];
                    $sortWords[$userword['id']]['training_translation_word'] = $userword['training_translation_word'];
                    $sortWords[$userword['id']]['training_cards'] = $userword['training_cards'];
                    $sortWords[$userword['id']]['training_audio'] = $userword['training_audio'];
                    $sortWords[$userword['id']]['training_constructor'] = $userword['training_constructor'];
                }
            $words = $sortWords;
            //echo '<pre>'.print_r($words, true).'</pre>';die;
            $vocabulary = null;
            if (Yii::$app->request->get('v'))
            {

                $vocabulary = [];
                if (Yii::$app->request->get('v') != -1)
                {
                    $vocabularyModel = Vocabulary::findOne(Yii::$app->request->get('v'));
                    $vocabulary['imageLink'] = $vocabularyModel->getImageLink();
                    $vocabulary['id'] = $vocabularyModel->id;
                    $vocabulary['name'] = $vocabularyModel->name;
                    $vocabulary['count'] = VocabularyWord::find()->where(['vocabulary_id'=>$vocabulary['id']])->count();
                }
                else
                {
                    $vocabulary['name'] = Yii::t('dictionaryMy', 'Words from content');
                    $vocabulary['id'] = -1;
                    $vocabulary['imageLink'] = Url::home(true).'web/source/images/vocabulary/content.png';
                    $vocabulary['count'] = count($words);
                }
            }
            $languageCode = Course::find()->where(['id'=>$user->course_id])->one()->getGoalLanguage()->translation_code;
            $q = "";
            $qProgress = "";
            $qTraining = "";
        }
        else
        {
            $vocabulary = json_decode(Yii::$app->request->post('vocabulary'), true);
            $languageCode = Yii::$app->request->post('languageCode');
            $words = json_decode(Yii::$app->request->post('words'), true);
            $q = Yii::$app->request->post('q')?Yii::$app->request->post('q'):'';
            $qProgress = Yii::$app->request->post('qProgress')?Yii::$app->request->post('qProgress'):'';
            $qTraining = Yii::$app->request->post('qTraining')?Yii::$app->request->post('qTraining'):'';
            if(Yii::$app->request->post('removeWord'))
            {
                UserWord::findOne(Yii::$app->request->post('id'))->delete();
                unset($words[Yii::$app->request->post('id')]);
            }
        }
        return $this->render('my', [
            'vocabulary' => $vocabulary,
            'languageCode' => $languageCode,
            'words' => $words,
            'q' => $q,
            'qProgress' => $qProgress,
            'qTraining' => $qTraining,
            ]);
    }

    public function actionVocabulary()
    {
        if (!Yii::$app->request->isPjax)
        {
            $user = Yii::$app->user->getIdentity();
            $vocabulary = ArrayHelper::toArray(Vocabulary::findOne(['id'=>Yii::$app->request->get('v'), 'course_id' =>$user->course_id]),  [
                'app\models\Vocabulary' =>
                    [
                        'id',
                        'name',
                        'course_id',
                        'group_id',
                        'image',
                        'imageLink'
                    ]
            ]);
            if(!Yii::$app->request->get('v') or $vocabulary == null)
                return $this->redirect(['dictionary/']);
            $vocabulary['isUserVocabulary'] = (UserVocabulary::findOne(['user_id'=>$user->id, 'vocabulary_id' => $vocabulary['id']]) != null);
            $words = ArrayHelper::toArray(Word::find()->where(['in', 'id', ArrayHelper::getColumn(VocabularyWord::findAll(['vocabulary_id' => $vocabulary['id']]), 'word_id')])->all(), [
                'app\models\Word' =>
                    ['id',
                        'original',
                        'translation']
            ]);
            $userwords = ArrayHelper::index(UserWord::find()->where(['in', 'word_id', ArrayHelper::getColumn($words, 'id')])->all(), 'word_id');
            foreach ($words as $index=>$word)
                if(isset($userwords[$word['id']]) and $userwords[$word['id']]['vocabulary_id'] == $vocabulary['id'])
                    $words[$index]['isUserWord'] = true;
                else
                    $words[$index]['isUserWord'] = false;
            $languageCode = Course::find()->where(['id'=>$user->course_id])->one()->getGoalLanguage()->translation_code;
        }
        else
        {
            $vocabulary = json_decode(Yii::$app->request->post('vocabulary'), true);
            $words = json_decode(Yii::$app->request->post('words'), true);
            $languageCode = Yii::$app->request->post('words');
            if (Yii::$app->request->post('addWord'))
            {
                if (!$vocabulary['isUserVocabulary'])
                {
                    $userVocabulary = new UserVocabulary();
                    $userVocabulary->user_id = Yii::$app->user->getId();
                    $userVocabulary->vocabulary_id = $vocabulary['id'];
                    $userVocabulary->save();
                    $vocabulary['isUserVocabulary'] = true;
                }
                $userWord = new UserWord();
                $userWord->user_id = Yii::$app->user->getId();
                $userWord->word_id = Yii::$app->request->post('id');
                $userWord->vocabulary_id = $vocabulary['id'];
                $userWord->save();
                foreach ($words as $index=>$word)
                    if($word['id'] == Yii::$app->request->post('id'))
                        $words[$index]['isUserWord'] = true;
            }
        }
        return $this->render('vocabulary', [
            'vocabulary' => $vocabulary,
            'words' => $words,
            'languageCode' => $languageCode
        ]);
    }

    public function actionNewGroup()
    {
        if (!in_array(Yii::$app->user->getIdentity()->status, [User::STATUS_AUTHOR, User::STATUS_ADMIN]))
            return $this->redirect(['dictionary/']);
        $newGroupForm = new DictionaryNewGroupForm();
        if (Yii::$app->request->isPost and $newGroupForm->load(Yii::$app->request->post()) and $newGroupForm->validate())
        {
            $vocabularyGroup = new VocabularyGroup();
            $vocabularyGroup->name = $newGroupForm->name;
            $vocabularyGroup->course_id = Yii::$app->user->getIdentity()->course_id;
            if ($vocabularyGroup->validate() and $vocabularyGroup->save())
                return $this->redirect(['dictionary/']);
        }
        return $this->render('new-group', [
            'newGroupForm' => $newGroupForm
        ]);
    }
    public function actionEditGroup()
    {
        $vocabularyGroup = VocabularyGroup::findOne(Yii::$app->request->get('vg'));
        if (!(in_array(Yii::$app->user->getIdentity()->status, [User::STATUS_AUTHOR, User::STATUS_ADMIN]) and Yii::$app->request->get('vg') and $vocabularyGroup))
            return $this->redirect(['dictionary/']);
        $newGroupForm = new DictionaryNewGroupForm();
        $newGroupForm->name = $vocabularyGroup->name;
        if (Yii::$app->request->isPost and $newGroupForm->load(Yii::$app->request->post()) and $newGroupForm->validate())
        {
            $vocabularyGroup->name = $newGroupForm->name;
            $vocabularyGroup->course_id = Yii::$app->user->getIdentity()->course_id;
            if ($vocabularyGroup->validate() and $vocabularyGroup->save())
                return $this->redirect(['dictionary/']);
        }
        return $this->render('edit-group', [
            'newGroupForm' => $newGroupForm
        ]);
    }
    public function actionNew()
    {
        $user = User::findOne(Yii::$app->user->getId());
        if (!in_array($user->status, [User::STATUS_AUTHOR, User::STATUS_ADMIN]))
            return $this->redirect(['dictionary/']);
        $dictionaryNewForm = new DictionaryNewForm();
        $words = [];
        while(count($words) < 100)
            $words[] = new DictionaryNewWordForm();
        if (Yii::$app->request->isPost)
        {
            $dictionaryNewForm->load(Yii::$app->request->post());
            $imageFile = UploadedFile::getInstance($dictionaryNewForm, 'image');
            ActiveRecord::loadMultiple($words, Yii::$app->request->post());
            if ($dictionaryNewForm->validate() and ActiveRecord::validateMultiple($words))
            {
                $vocabulary = new Vocabulary();
                $vocabulary->course_id = $user->course_id;
                $vocabulary->group_id = $dictionaryNewForm->group_id;
                $vocabulary->name = $dictionaryNewForm->name;
                $vocabulary->save();
                if ($imageFile)
                    $vocabulary->setImage($imageFile);
                foreach ($words as $word)
                {
                    if (!(empty(trim($word->original)) and empty(trim($word->translation))))
                    {
                        $tempWordModel = Word::findOne(['original'=>$word->original, 'translation'=>$word->translation, 'course_id'=>$user->course_id]);
                        if ($tempWordModel == null)
                        {
                            $tempWordModel = new Word();
                            $tempWordModel->original = $word->original;
                            $tempWordModel->translation = $word->translation;
                            $tempWordModel->course_id = $user->course_id;
                            $tempWordModel->save();
                        }
                        $tempVocabularyWord = new VocabularyWord();
                        $tempVocabularyWord->word_id = $tempWordModel->id;
                        $tempVocabularyWord->vocabulary_id = $vocabulary->id;
                        $tempVocabularyWord->save();
                    }
                    return $this->redirect(['dictionary/vocabulary', 'v'=>$vocabulary->id]);
                }
            }
            echo '<pre>'.print_r(Yii::$app->request->post(), true).'</pre>';die;
        }
        while(count($words) < 100)
            $words[] = new DictionaryNewWordForm();
        return $this->render('new', [
            'dictionaryNewForm' => $dictionaryNewForm,
            'words' => $words
        ]);
    }
    public function actionEdit()
    {
        $user = User::findOne(Yii::$app->user->getId());
        $vocabulary = Vocabulary::findOne(Yii::$app->request->get('v'));
        if (!(in_array(Yii::$app->user->getIdentity()->status, [User::STATUS_AUTHOR, User::STATUS_ADMIN]) and Yii::$app->request->get('v') and $vocabulary))
            return $this->redirect(['dictionary/']);
        $vocabularyWords = VocabularyWord::findAll(['vocabulary_id' => $vocabulary->id]);
        $wordsModels = ArrayHelper::index(Word::find()->where(['in', 'id', ArrayHelper::getColumn($vocabularyWords, 'word_id')])->all(), 'id');
        $dictionaryNewForm = new DictionaryNewForm();
        $words = [];
        if (Yii::$app->request->isPost)
        {
            while(count($words) < 100)
                $words[] = new DictionaryNewWordForm();
            $dictionaryNewForm->load(Yii::$app->request->post());
            $imageFile = UploadedFile::getInstance($dictionaryNewForm, 'image');
            ActiveRecord::loadMultiple($words, Yii::$app->request->post());
            if ($dictionaryNewForm->validate() and ActiveRecord::validateMultiple($words))
            {
                if ($imageFile)
                    $vocabulary->setImage($imageFile);
                if ($dictionaryNewForm->name != $vocabulary->name)
                {
                    $vocabulary->name = $dictionaryNewForm->name;
                    $vocabulary->save();
                }
                foreach ($vocabularyWords as $vocabularyWord)
                {
                    $deleted = true;
                    foreach ($words as $word)
                        if ($wordsModels[$vocabularyWord->word_id]['original'] == $word->original and $wordsModels[$vocabularyWord->word_id]['translation'] == $word->translation)
                        {
                            $deleted = false;
                            break;
                        }
                    if ($deleted)
                    {
                        $userWords = UserWord::findAll(['word_id'=>$vocabularyWord->word_id, 'vocabulary_id'=>$vocabulary->id]);
                        foreach ($userWords as $index=>$userWord)
                        {
                            $userWords[$index]->vocabulary_id = 0;
                            $userWords[$index]->save();
                        }
                    }
                    $vocabularyWord->delete();
                }
                foreach ($words as $word)
                {
                    $tempWord = Word::findOne(['original'=>$word->original, 'translation'=>$word->translation, 'course_id'=>$vocabulary->course_id]);
                    if($tempWord == null)
                    {
                        $tempWord = new Word();
                        $tempWord->original = $word->original;
                        $tempWord->translation = $word->translation;
                        $tempWord->course_id = $vocabulary->course_id;
                        $tempWord->save();
                    }
                    $tempVocabularyWord = new VocabularyWord();
                    $tempVocabularyWord->vocabulary_id = $vocabulary->id;
                    $tempVocabularyWord->word_id = $tempWord->id;
                    $tempVocabularyWord->save();
                }
                return $this->redirect(['dictionary/vocabulary', 'v'=>$vocabulary->id]);
            }
        }
        else
        {
            $dictionaryNewForm->name = $vocabulary->name;
            $dictionaryNewForm->group_id = $vocabulary->group_id;
            $image = $vocabulary->image;
            $words = [];
            foreach ($vocabularyWords as $vocabularyWord)
            {
                $tempWord = new DictionaryNewWordForm();
                $tempWord->original = $wordsModels[$vocabularyWord->word_id]['original'];
                $tempWord->translation = $wordsModels[$vocabularyWord->word_id]['translation'];
                $words[] = $tempWord;
            }
        }
        while(count($words) < 100)
            $words[] = new DictionaryNewWordForm();
        return $this->render('edit', [
            'dictionaryNewForm' => $dictionaryNewForm,
            'words' => $words,
            'image' => $image
        ]);
    }

    public function actionAjaxRemoveVocabulary($id)
    {
        if(Yii::$app->request->isAjax and !Yii::$app->user->isGuest and Vocabulary::findOne($id) and UserVocabulary::findOne(['user_id'=>Yii::$app->user->getId(), 'vocabulary_id'=>$id]))
        {
            $userwords = UserWord::find()->where(['vocabulary_id' => $id, 'user_id' => Yii::$app->user->getId()])->all();
            foreach ($userwords as $userword)
                $userword->delete();
            $userVocabulary = UserVocabulary::findOne(['vocabulary_id' => $id, 'user_id' => Yii::$app->user->getId()]);
            $userVocabulary->delete();
        }
    }
    public function actionAjaxAddVocabulary($id)
    {
        if(Yii::$app->request->isAjax and !Yii::$app->user->isGuest and Vocabulary::findOne($id) and !UserVocabulary::findOne(['user_id'=>Yii::$app->user->getId(), 'vocabulary_id'=>$id]))
        {
            $userVocabulary = new UserVocabulary();
            $userVocabulary->vocabulary_id = $id;
            $userVocabulary->user_id = Yii::$app->user->getId();
            $userVocabulary->save();
            $vocabularyWords = array_reverse(VocabularyWord::findAll(['vocabulary_id' => $id]));
            foreach ($vocabularyWords as $vocabularyWord)
            {
                $oldUserWord = UserWord::findOne(['user_id'=>Yii::$app->user->getId(), 'word_id' => $vocabularyWord->word_id, 'vocabulary_id'=>$id]);
                if ($oldUserWord)
                    $oldUserWord->delete();
                $userword = new UserWord();
                $userword->user_id = Yii::$app->user->getId();
                $userword->vocabulary_id = $id;
                $userword->word_id = $vocabularyWord->word_id;
                $userword->save();
            }
        }
    }

    public function actionAjaxDeleteVocabulary($id)
    {
        if(Yii::$app->request->isAjax and in_array(Yii::$app->user->getIdentity()->status, [User::STATUS_AUTHOR, User::STATUS_ADMIN]) and Vocabulary::findOne($id) )
            Vocabulary::findOne($id)->delete();
    }

    public function actionAjaxDeleteVocabularyGroup($id)
    {
        if(Yii::$app->request->isAjax and in_array(Yii::$app->user->getIdentity()->status, [User::STATUS_AUTHOR, User::STATUS_ADMIN]) and VocabularyGroup::findOne($id) )
            VocabularyGroup::findOne($id)->delete();
    }
}