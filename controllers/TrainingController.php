<?php


namespace app\controllers;


use app\models\Course;
use app\models\UserVocabulary;
use app\models\UserWord;
use app\models\Word;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii2mod\query\ArrayQuery;

function str_split_unicode($str, $length = 1) {
    $tmp = preg_split('~~u', $str, -1, PREG_SPLIT_NO_EMPTY);
    if ($length > 1) {
        $chunks = array_chunk($tmp, $length);
        foreach ($chunks as $i => $chunk) {
            $chunks[$i] = join('', (array) $chunk);
        }
        $tmp = $chunks;
    }
    return $tmp;
}

class TrainingController extends Controller
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
        $user = Yii::$app->user->getIdentity();
        if(Yii::$app->request->get('v') != -1 and Yii::$app->request->get('v') and UserVocabulary::find()
                ->where(['vocabulary_id'=>Yii::$app->request->get('v')])
                ->andWhere(['user_id' => $user->id])
                ->one() == null)
            return $this->redirect(['training/']);
        $courseWordIds = Word::find()
            ->where(['course_id'=>$user->course_id])
            ->select('id')
            ->asArray()
            ->all();
        $courseWordIds = ArrayHelper::getColumn($courseWordIds, 'id');
        $userWordQuery = UserWord::find()->where(['user_id'=>$user->id])->andWhere(['in', 'word_id', $courseWordIds]);
        if (Yii::$app->request->get('v'))
            $userWordQuery = $userWordQuery->andWhere(['vocabulary_id' => Yii::$app->request->get('v')]);
        $userwords = ArrayHelper::toArray($userWordQuery->all(), [
            'app\models\UserWord' => [
                'id',
                'training_word_translation',
                'training_translation_word',
                'training_cards',
                'training_audio',
                'training_constructor',
                'trainingStatus'
            ]
        ]);
        $countQuery = new ArrayQuery();
        $countQuery->from($userwords)->where(['!=', 'trainingStatus', UserWord::TRAINING_STATUS_LEARNED]);
        $countWordTranslation = $countQuery->andWhere(['training_word_translation' => 0])->count();
        $countQuery->from($userwords)->where(['!=', 'trainingStatus', UserWord::TRAINING_STATUS_LEARNED]);
        $countTranslationWord = $countQuery->andWhere(['training_translation_word' => 0])->count();
        $countQuery->from($userwords)->where(['!=', 'trainingStatus', UserWord::TRAINING_STATUS_LEARNED]);
        $countAudio = $countQuery->andWhere(['training_audio' => 0])->count();
        $countQuery->from($userwords)->where(['!=', 'trainingStatus', UserWord::TRAINING_STATUS_LEARNED]);
        $countCards = $countQuery->andWhere(['training_cards' => 0])->count();
        $countQuery->from($userwords)->where(['!=', 'trainingStatus', UserWord::TRAINING_STATUS_LEARNED]);
        $countConstructor = $countQuery->andWhere(['training_constructor' => 0])->count();
        return $this->render('index', [
            'countWordTranslation' => $countWordTranslation,
            'countTranslationWord' => $countTranslationWord,
            'countCards' => $countCards,
            'countAudio' => $countAudio,
            'countConstructor' => $countConstructor,
        ]);
    }

    public function actionWordTranslation()
    {
        $qResults = [];
        $qCorrect = 0;
        $qWrong = 0;
        if (!Yii::$app->request->isPjax)
        {
            $user = Yii::$app->user->getIdentity();
            if(Yii::$app->request->get('v') != -1 and Yii::$app->request->get('v') and UserVocabulary::find()
                    ->where(['vocabulary_id'=>Yii::$app->request->get('v')])
                    ->andWhere(['user_id' => $user->id])
                    ->one() == null)
                return $this->redirect(['training/word-translation']);
            $userWordQuery = UserWord::find()->where(['user_id'=>$user->id])->andWhere(['training_word_translation'=>0]);
            if (Yii::$app->request->get('v'))
                $userWordQuery = $userWordQuery->andWhere(['vocabulary_id' => Yii::$app->request->get('v')]);
            $userWordArray = ArrayHelper::toArray($userWordQuery->all(), [
                'app\models\UserWord' => [
                    'id',
                    'word_id',
                    'vocabulary_id',
                    'training_word_translation',
                    'trainingStatus'
                ]
            ]);
            $userWordArray = ArrayHelper::Index($userWordArray, 'word_id');
            $wordArray = Word::find()
                ->where(['course_id'=>$user->course_id])
                ->andWhere(['in', 'id', ArrayHelper::getColumn($userWordArray, 'word_id')])
                ->asArray()
                ->all();
            shuffle($wordArray);
            $wordSearchQuery = new ArrayQuery();
            $wordSearchQuery->from(Word::find()->where(['course_id'=>$user->course_id])->asArray()->all());
            $qWords = [];
            $qOptions = [];
            foreach ($wordArray as $word)
            {
                if (count($qWords) == 10)
                    break;
                $userword = $userWordArray[$word['id']];
                if ($userword['training_word_translation'] == 0 and $userword['trainingStatus'] != UserWord::TRAINING_STATUS_LEARNED)
                {
                    $qWords[] = $userword['id'];
                    $tempOptions = [];
                    $tempOptions[] = $word['translation'];
                    $alternativeTranslations = ArrayHelper::getColumn($wordSearchQuery->where(['original' => $word['original']])->all(), 'translation');
                    $whitelist = $wordSearchQuery->where(['not in', 'translation', $alternativeTranslations])->all();
                    //echo '<pre>'.print_r($whitelist, true).'</pre>';die;
                    $rand_options = array_rand($whitelist, 3);
                    foreach ($rand_options as $rand_option)
                        $tempOptions[] = $whitelist[$rand_option]['translation'];
                    shuffle($tempOptions);
                    $qOptions[] = $tempOptions;
                }
            }
            $qStep = 1;
            $qAnswers = [];
            if (count($qWords) == 0)
                return $this->redirect(['training/']);
        }
        else
        {
            $qWords = json_decode(Yii::$app->request->post('qWords'));
            $qOptions = json_decode(Yii::$app->request->post('qOptions'));
            $qAnswers = Yii::$app->request->post('qAnswers')?json_decode(Yii::$app->request->post('qAnswers')):[];
            $qStep = Yii::$app->request->post('qStep');
            if (count($qAnswers) < $qStep)
                $qAnswers[] = Yii::$app->request->post('qSelected')?Yii::$app->request->post('qSelected'):"";
            else
                $qStep++;
            if ($qStep > count($qWords))
            {
                foreach ($qWords as $index=>$qWord)
                {
                    $tempResult = [];
                    $userWord = UserWord::find()->where(['id'=>$qWord])->one();
                    $word = Word::find()->where(['id'=>$userWord->word_id])->one();
                    $tempResult['word'] = $word->original;
                    $tempResult['translation'] = $word->translation;
                    if ($qAnswers[$index] != null)
                    {
                        if ($qOptions[$index][$qAnswers[$index]-1] == $word->translation)
                        {
                            $userWord->training_word_translation = 1;
                            $userWord->save();
                            $tempResult['correct'] = 1;
                            $qCorrect++;
                        }
                    }
                    else
                    {
                        $userWord->training_word_translation = 0;
                        $userWord->save();
                        $tempResult[] = 0;
                        $qWrong++;
                    }
                    $qResults[] = $tempResult;
                }
            }
        }
        return $this->render('word-translation', [
            'qWords' => $qWords,
            'qOptions' => $qOptions,
            'qStep' => $qStep,
            'qAnswers' => $qAnswers,
            'qResults' => $qResults,
            'qCorrect' => $qCorrect,
            'qWrong' => $qWrong
        ]);
    }

    public function actionTranslationWord()
    {
        $qResults = [];
        $qCorrect = 0;
        $qWrong = 0;
        if (!Yii::$app->request->isPjax)
        {
            $user = Yii::$app->user->getIdentity();
            if(Yii::$app->request->get('v') != -1 and Yii::$app->request->get('v') and UserVocabulary::find()
                    ->where(['vocabulary_id'=>Yii::$app->request->get('v')])
                    ->andWhere(['user_id' => $user->id])
                    ->one() == null)
                return $this->redirect(['training/translation-word']);
            $userWordQuery = UserWord::find()->where(['user_id'=>$user->id])->andWhere(['training_translation_word'=>0]);
            if (Yii::$app->request->get('v'))
                $userWordQuery = $userWordQuery->andWhere(['vocabulary_id' => Yii::$app->request->get('v')]);
            $userWordArray = ArrayHelper::toArray($userWordQuery->all(), [
                'app\models\UserWord' => [
                    'id',
                    'word_id',
                    'vocabulary_id',
                    'training_translation_word',
                    'trainingStatus'
                ]
            ]);
            $userWordArray = ArrayHelper::Index($userWordArray, 'word_id');
            $wordArray = Word::find()
                ->where(['course_id'=>$user->course_id])
                ->andWhere(['in', 'id', ArrayHelper::getColumn($userWordArray, 'word_id')])
                ->asArray()
                ->all();
            shuffle($wordArray);
            $wordSearchQuery = new ArrayQuery();
            $wordSearchQuery->from(Word::find()->where(['course_id'=>$user->course_id])->asArray()->all());
            $qWords = [];
            $qOptions = [];
            foreach ($wordArray as $word)
            {
                if (count($qWords) == 10)
                    break;
                $userword = $userWordArray[$word['id']];
                if ($userword['training_translation_word'] == 0 and $userword['trainingStatus'] != UserWord::TRAINING_STATUS_LEARNED)
                {
                    $qWords[] = $userword['id'];
                    $tempOptions = [];
                    $tempOptions[] = $word['original'];
                    $alternativeTranslations = ArrayHelper::getColumn($wordSearchQuery->where(['translation' => $word['translation']])->all(), 'original');
                    $whitelist = $wordSearchQuery->where(['not in', 'original', $alternativeTranslations])->all();
                    $rand_options = array_rand($whitelist, 3);
                    foreach ($rand_options as $rand_option)
                        $tempOptions[] = $whitelist[$rand_option]['original'];
                    shuffle($tempOptions);
                    $qOptions[] = $tempOptions;
                }
            }
            $qStep = 1;
            $qAnswers = [];
            if (count($qWords) == 0)
                return $this->redirect(['training/']);
        }
        else
        {
            $qWords = json_decode(Yii::$app->request->post('qWords'));
            $qOptions = json_decode(Yii::$app->request->post('qOptions'));
            $qAnswers = Yii::$app->request->post('qAnswers')?json_decode(Yii::$app->request->post('qAnswers')):[];
            $qStep = Yii::$app->request->post('qStep');
            if (count($qAnswers) < $qStep)
                $qAnswers[] = Yii::$app->request->post('qSelected')?Yii::$app->request->post('qSelected'):"";
            else
                $qStep++;
            if ($qStep > count($qWords))
            {
                foreach ($qWords as $index=>$qWord)
                {
                    $tempResult = [];
                    $userWord = UserWord::find()->where(['id'=>$qWord])->one();
                    $word = Word::find()->where(['id'=>$userWord->word_id])->one();
                    $tempResult['word'] = $word->original;
                    $tempResult['translation'] = $word->translation;
                    if ($qAnswers[$index] != null)
                    {
                        if ($qOptions[$index][$qAnswers[$index]-1] == $word->original)
                        {
                            $userWord->training_translation_word = 1;
                            $userWord->save();
                            $tempResult['correct'] = 1;
                            $qCorrect++;
                        }
                    }
                    else
                    {
                        $userWord->training_translation_word = 0;
                        $userWord->save();
                        $tempResult[] = 0;
                        $qWrong++;
                    }
                    $qResults[] = $tempResult;
                }
            }
        }
        return $this->render('translation-word', [
            'qWords' => $qWords,
            'qOptions' => $qOptions,
            'qStep' => $qStep,
            'qAnswers' => $qAnswers,
            'qResults' => $qResults,
            'qCorrect' => $qCorrect,
            'qWrong' => $qWrong
        ]);
    }

    public function actionAudio()
    {
        $qResults = [];
        $qCorrect = 0;
        $qWrong = 0;
        if (!Yii::$app->request->isPjax)
        {
            $user = Yii::$app->user->getIdentity();
            $languageCode = Course::find()->where(['id'=>$user->course_id])->one()->getGoalLanguage()->translation_code;
            if(Yii::$app->request->get('v') != -1 and Yii::$app->request->get('v') and UserVocabulary::find()
                    ->where(['vocabulary_id'=>Yii::$app->request->get('v')])
                    ->andWhere(['user_id' => $user->id])
                    ->one() == null)
                return $this->redirect(['training/word-translation']);
            $userWordQuery = UserWord::find()->where(['user_id'=>$user->id])->andWhere(['training_audio'=>0]);
            if (Yii::$app->request->get('v'))
                $userWordQuery = $userWordQuery->andWhere(['vocabulary_id' => Yii::$app->request->get('v')]);
            $userWordArray = ArrayHelper::toArray($userWordQuery->all(), [
                'app\models\UserWord' => [
                    'id',
                    'word_id',
                    'vocabulary_id',
                    'training_audio',
                    'trainingStatus'
                ]
            ]);
            $userWordArray = ArrayHelper::Index($userWordArray, 'word_id');
            $wordArray = Word::find()
                ->where(['course_id'=>$user->course_id])
                ->andWhere(['in', 'id', ArrayHelper::getColumn($userWordArray, 'word_id')])
                ->asArray()
                ->all();
            shuffle($wordArray);
            $wordSearchQuery = new ArrayQuery();
            $wordSearchQuery->from(Word::find()->where(['course_id'=>$user->course_id])->asArray()->all());
            $qWords = [];
            $qOptions = [];
            foreach ($wordArray as $word)
            {
                if (count($qWords) == 10)
                    break;
                $userword = $userWordArray[$word['id']];
                if ($userword['training_audio'] == 0 and $userword['trainingStatus'] != UserWord::TRAINING_STATUS_LEARNED)
                {
                    $qWords[] = $userword['id'];
                    $tempOptions = [];
                    $tempOptions[] = $word['translation'];

                    $alternativeTranslations = ArrayHelper::getColumn($wordSearchQuery->where(['original' => $word['original']])->all(), 'translation');
                    $whitelist = $wordSearchQuery->where(['not in', 'translation', $alternativeTranslations])->all();
                    //echo '<pre>'.print_r($whitelist, true).'</pre>';die;
                    $rand_options = array_rand($whitelist, 3);
                    foreach ($rand_options as $rand_option)
                        $tempOptions[] = $whitelist[$rand_option]['translation'];
                    shuffle($tempOptions);
                    $qOptions[] = $tempOptions;
                }
            }
            $qStep = 1;
            $qAnswers = [];
            if (count($qWords) == 0)
                return $this->redirect(['training/']);
        }
        else
        {
            $languageCode = Yii::$app->request->post('languageCode');
            $qWords = json_decode(Yii::$app->request->post('qWords'));
            $qOptions = json_decode(Yii::$app->request->post('qOptions'));
            $qAnswers = Yii::$app->request->post('qAnswers')?json_decode(Yii::$app->request->post('qAnswers')):[];
            $qStep = Yii::$app->request->post('qStep');
            if (count($qAnswers) < $qStep)
                $qAnswers[] = Yii::$app->request->post('qSelected')?Yii::$app->request->post('qSelected'):"";
            else
                $qStep++;
            if ($qStep > count($qWords))
            {
                foreach ($qWords as $index=>$qWord)
                {
                    $tempResult = [];
                    $userWord = UserWord::find()->where(['id'=>$qWord])->one();
                    $word = Word::find()->where(['id'=>$userWord->word_id])->one();
                    $tempResult['word'] = $word->original;
                    $tempResult['translation'] = $word->translation;
                    if ($qAnswers[$index] != null)
                    {
                        if ($qOptions[$index][$qAnswers[$index]-1] == $word->translation)
                        {
                            $userWord->training_audio = 1;
                            $userWord->save();
                            $tempResult['correct'] = 1;
                            $qCorrect++;
                        }
                    }
                    else
                    {
                        $userWord->training_audio = 0;
                        $userWord->save();
                        $tempResult[] = 0;
                        $qWrong++;
                    }
                    $qResults[] = $tempResult;
                }
            }
        }
        return $this->render('audio', [
            'qWords' => $qWords,
            'qOptions' => $qOptions,
            'qStep' => $qStep,
            'qAnswers' => $qAnswers,
            'qResults' => $qResults,
            'qCorrect' => $qCorrect,
            'qWrong' => $qWrong,
            'languageCode' => $languageCode
        ]);
    }

    public function actionCards()
    {
        $qResults = [];
        $qCorrect = 0;
        $qWrong = 0;
        if (!Yii::$app->request->isPjax)
        {
            $user = Yii::$app->user->getIdentity();
            if(Yii::$app->request->get('v') != -1 and Yii::$app->request->get('v') and UserVocabulary::find()
                    ->where(['vocabulary_id'=>Yii::$app->request->get('v')])
                    ->andWhere(['user_id' => $user->id])
                    ->one() == null)
                return $this->redirect(['training/word-translation']);
            $userWordQuery = UserWord::find()->where(['user_id'=>$user->id])->andWhere(['training_cards'=>0]);
            if (Yii::$app->request->get('v'))
                $userWordQuery = $userWordQuery->andWhere(['vocabulary_id' => Yii::$app->request->get('v')]);
            $userWordArray = ArrayHelper::toArray($userWordQuery->all(), [
                'app\models\UserWord' => [
                    'id',
                    'word_id',
                    'vocabulary_id',
                    'training_cards',
                    'trainingStatus'
                ]
            ]);
            $userWordArray = ArrayHelper::Index($userWordArray, 'word_id');
            $wordArray = Word::find()
                ->where(['course_id'=>$user->course_id])
                ->andWhere(['in', 'id', ArrayHelper::getColumn($userWordArray, 'word_id')])
                ->asArray()
                ->all();
            shuffle($wordArray);
            $qWords = [];
            foreach ($wordArray as $word)
            {
                if (count($qWords) == 10)
                    break;
                $userword = $userWordArray[$word['id']];
                if ($userword['training_cards'] == 0 and $userword['trainingStatus'] != UserWord::TRAINING_STATUS_LEARNED)
                    $qWords[] = $userword['id'];
            }
            $qStep = 1;
            $qAnswers = [];
            if (count($qWords) == 0)
                return $this->redirect(['training/']);
        }
        else
        {
            $qWords = json_decode(Yii::$app->request->post('qWords'));
            $qAnswers = Yii::$app->request->post('qAnswers')?json_decode(Yii::$app->request->post('qAnswers')):[];
            $qStep = Yii::$app->request->post('qStep');
            if (count($qAnswers) < $qStep)
                $qAnswers[] = Yii::$app->request->post('qSelected')?Yii::$app->request->post('qSelected'):"";
            else
            {
                $qAnswers[count($qAnswers)-1] = Yii::$app->request->post('qSelected')?Yii::$app->request->post('qSelected'):"";
                $qStep++;
            }
            if ($qStep > count($qWords))
            {
                foreach ($qWords as $index=>$qWord)
                {
                    $tempResult = [];
                    $userWord = UserWord::find()->where(['id'=>$qWord])->one();
                    $word = Word::find()->where(['id'=>$userWord->word_id])->one();
                    $tempResult['word'] = $word->original;
                    $tempResult['translation'] = $word->translation;
                    $tempResult['correct'] = $qAnswers[$index]?1:0;
                    $userWord->training_cards = $tempResult['correct'];
                    $userWord->save();
                    $qCorrect+=$tempResult['correct'];
                    $qResults[] = $tempResult;
                }
            }
        }
        return $this->render('cards', [
            'qWords' => $qWords,
            'qStep' => $qStep,
            'qAnswers' => $qAnswers,
            'qResults' => $qResults,
            'qCorrect' => $qCorrect,
            'qWrong' => $qWrong,
        ]);

    }

    public function actionConstructor()
    {
        $qResults = [];
        $qCorrect = 0;
        $qWrong = 0;
        if (!Yii::$app->request->isPjax)
        {
            $user = Yii::$app->user->getIdentity();
            if(Yii::$app->request->get('v') != -1 and Yii::$app->request->get('v') and UserVocabulary::find()
                    ->where(['vocabulary_id'=>Yii::$app->request->get('v')])
                    ->andWhere(['user_id' => $user->id])
                    ->one() == null)
                return $this->redirect(['training/word-translation']);
            $userWordQuery = UserWord::find()->where(['user_id'=>$user->id])->andWhere(['training_constructor'=>0]);
            if (Yii::$app->request->get('v'))
                $userWordQuery = $userWordQuery->andWhere(['vocabulary_id' => Yii::$app->request->get('v')]);
            $userWordArray = ArrayHelper::toArray($userWordQuery->all(), [
                'app\models\UserWord' => [
                    'id',
                    'word_id',
                    'vocabulary_id',
                    'training_constructor',
                    'trainingStatus'
                ]
            ]);
            $userWordArray = ArrayHelper::Index($userWordArray, 'word_id');
            $wordArray = Word::find()
                ->where(['course_id'=>$user->course_id])
                ->andWhere(['in', 'id', ArrayHelper::getColumn($userWordArray, 'word_id')])
                ->asArray()
                ->all();
            shuffle($wordArray);
            $qWords = [];
            foreach ($wordArray as $word)
            {
                if (count($qWords) == 10)
                    break;
                $userword = $userWordArray[$word['id']];
                if ($userword['training_cards'] == 0 and $userword['trainingStatus'] != UserWord::TRAINING_STATUS_LEARNED)
                {
                    $tempWord = [];
                    $tempWord['mistakes'] = 0;
                    $tempWord['guessed_letters'] = 0;
                    $tempWord['original'] = $word['original'];
                    $tempWord['translation'] = $word['translation'];
                    $tempWord['id'] = $userword['id'];
                    $tempWord['letters'] = str_split_unicode(mb_strtolower($word['original']));
                    $uniqueLettersArray = array_unique($tempWord['letters']);
                    shuffle($uniqueLettersArray);
                    foreach ($uniqueLettersArray as $index=>$uniqueLetter)
                    {
                        $tempWord['letter_symbols'][$index+1] = $uniqueLetter;
                        $tempWord['letter_count'][$index+1] = 0;
                        foreach ($tempWord['letters'] as $letter)
                            if ($letter == $uniqueLetter)
                                $tempWord['letter_count'][$index+1]++;
                    }
                    $qWords[] = $tempWord;
                }
            }
            $qStep = 1;
            if (count($qWords) == 0)
                return $this->redirect(['training/']);
        }
        else
        {

            $qWords = json_decode(Yii::$app->request->post('qWords'), true);
            $qStep = Yii::$app->request->post('qStep');
            $qSelected = Yii::$app->request->post('qSelected');
            if ($qWords[$qStep-1]['guessed_letters'] < count($qWords[$qStep-1]['letters']))
            {
                if ($qSelected === "0")
                {
                    $qWords[$qStep-1]['guessed_letters'] = count($qWords[$qStep-1]['letters']);
                    $qWords[$qStep-1]['mistakes'] = 99;
                }
                elseif($qWords[$qStep-1]['letter_symbols'][$qSelected] != $qWords[$qStep-1]['letters'][$qWords[$qStep-1]['guessed_letters']])
                {
                    $qWords[$qStep-1]['mistakes']++;
                }
                elseif($qWords[$qStep-1]['letter_symbols'][$qSelected] == $qWords[$qStep-1]['letters'][$qWords[$qStep-1]['guessed_letters']])
                {
                    $qWords[$qStep-1]['guessed_letters']++;
                    $qWords[$qStep-1]['letter_count'][$qSelected]--;
                }
            }
            else
            {
                $qStep++;
            }
            if ($qStep > count($qWords))
            {
                foreach ($qWords as $index=>$qWord)
                {
                    $tempResult = [];
                    $userWord = UserWord::find()->where(['id'=>$qWord])->one();
                    $word = Word::find()->where(['id'=>$userWord->word_id])->one();
                    $tempResult['word'] = $word->original;
                    $tempResult['translation'] = $word->translation;
                    if ($qWord['mistakes'] < 2)
                    {
                        $userWord->training_constructor = 1;
                        $userWord->save();
                        $tempResult['correct'] = 1;
                        $qCorrect++;
                    }
                    else
                    {
                        $userWord->training_constructor = 0;
                        $userWord->save();
                        $tempResult[] = 0;
                        $qWrong++;
                    }
                    $qResults[] = $tempResult;
                }
            }
        }
        return $this->render('constructor', [
            'qWords' => $qWords,
            'qStep' => $qStep,
            'qResults' => $qResults,
            'qCorrect' => $qCorrect,
            'qWrong' => $qWrong,
        ]);
    }
}