<?php

namespace app\controllers;

use app\models\Content;
use app\models\ContentSpan;
use app\models\Course;
use app\models\forms\ContentNewForm;
use app\models\Language;
use app\models\User;
use app\models\UserContent;
use app\models\UserWord;
use app\models\Word;
use Yii;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Cookie;
use yii\web\Response;
use yii\web\UploadedFile;

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

class ContentController extends \yii\web\Controller
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

    public function actionIndex()
    {
        if (!Yii::$app->request->isPjax)
        {
            $user = Yii::$app->user->getIdentity();
            $contents = ArrayHelper::toArray(Content::find()
                ->where(['course_id' => $user->course_id])
                ->all(), [
                'app\models\Content' =>
                    [
                        'id',
                        'name',
                        'complexity',
                        'course_id',
                        'image',
                        'imageLink'
                    ]
            ]);
            $userContentIds = ArrayHelper::getColumn(UserContent::find()->where(['user_id'=>$user->id])->all(), 'content_id');
            $q = null;
        }
        else
        {
            $contents = json_decode(Yii::$app->request->post('contents'), true);
            $userContentIds = json_decode(Yii::$app->request->post('userContentIds'), true);
            $q = Yii::$app->request->post('q');
        }
        return $this->render('index', [
            'contents' => $contents,
            'userContentIds' => $userContentIds,
            'q' => $q
        ]);
    }

    public function actionView()
    {
        if (!Yii::$app->request->isPjax)
        {
            $user = Yii::$app->user->getIdentity();
            $contentId = Yii::$app->request->get('c');
            $content = Content::find()
                ->where(['id'=>$contentId, 'course_id'=>$user->course_id])
                ->asArray()
                ->one();
            if ($contentId == null or $content == null)
                return $this->redirect(['content/']);
            $course = Course::findOne($user->course_id);
            $content['original_language'] = Language::findOne($course->original_language_id)->translation_code;
            $content['goal_language'] = Language::findOne($course->goal_language_id)->translation_code;
            $contentSpans = ContentSpan::find()->where(['content_id'=>$contentId])->asArray()->all();
            $contentSpansBySentences = ArrayHelper::index($contentSpans, 'position', 'sentence_position');
            $selectedSpanOriginals = [];
            $selectedSpanTranslations = [];
            $sentenceIds = array_unique(ArrayHelper::getColumn($contentSpans, 'sentence_position'));
            sort($sentenceIds);
            for($i = $sentenceIds[0]; $i <= $sentenceIds[count($sentenceIds)-1]; $i++)
            {
                if ($contentSpansBySentences[$i] == null)
                    $contentSpansBySentences[$i] = 'empty';
            }
            ksort($contentSpansBySentences);

        }
        else
        {
            $content = json_decode(Yii::$app->request->post('content'), true);
            $contentSpans = json_decode(Yii::$app->request->post('contentSpans'), true);
            $contentSpansBySentences = json_decode(Yii::$app->request->post('contentSpansBySentences'), true);
            $selectedSpanOriginals = json_decode(Yii::$app->request->post('selectedSpanOriginals'), true);
            if($selectedSpanOriginals==null) $selectedSpanOriginals = [];
            $selectedSpanTranslations = json_decode(Yii::$app->request->post('selectedSpanTranslations'), true);
            if($selectedSpanTranslations==null) $selectedSpanTranslations = [];

            if (Yii::$app->request->post('addWord'))
            {
                $original = Yii::$app->request->post('original');
                $translation = Yii::$app->request->post('translation');
                $selectedSpanOriginals[] = $original;
                $selectedSpanTranslations[] = $translation;
            }
            elseif (Yii::$app->request->post('deleteWord'))
            {
                $original = Yii::$app->request->post('original');
                $translation = Yii::$app->request->post('translation');
                $original_indexes = [];
                $translation_indexes = [];
                foreach ($selectedSpanOriginals as $index=>$value)
                {
                    if ($selectedSpanOriginals[$index] == $original)
                        $original_indexes[]= $index;
                    if ($selectedSpanTranslations[$index] == $translation)
                        $translation_indexes[]= $index;
                }
                foreach (array_intersect($original_indexes, $translation_indexes) as $index)
                {
                    unset($selectedSpanOriginals[$index]);
                    unset($selectedSpanTranslations[$index]);
                }
                $selectedSpanOriginals = array_values($selectedSpanOriginals);
                $selectedSpanTranslations = array_values($selectedSpanTranslations);


            }
            elseif(Yii::$app->request->post('complete'))
            {
                $user = Yii::$app->user->getIdentity();
                foreach ($selectedSpanOriginals as $index=>$value)
                {
                    $original = mb_strtolower($selectedSpanOriginals[$index]);
                    $translation = mb_strtolower($selectedSpanTranslations[$index]);
                    $word = Word::find()
                        ->where(['course_id' => $content['course_id']])
                        ->andWhere(['original' => $original])
                        ->andWhere(['translation' => $translation])
                        ->limit(1)
                        ->one();
                    if (!$word)
                    {
                        $word = new Word();
                        $word->original = $original;
                        $word->translation = $translation;
                        $word->course_id = $content['course_id'];
                        $word->save();
                    }
                    $userword = UserWord::find()
                        ->where(['user_id'=>$user->id])
                        ->andWhere(['word_id'=>$word->id])
                        ->andWhere(['vocabulary_id' => -1])
                        ->limit(1)
                        ->one();
                    if($userword)
                        $userword->delete();
                    $userword = new UserWord();
                    $userword->user_id = $user->id;
                    $userword->vocabulary_id = -1;
                    $userword->word_id = $word->id;
                    $userword->save();
                }

                if (!UserContent::findOne(['user_id'=>Yii::$app->user->getId(), 'content_id'=>$content['id']]))
                {
                    $userContent = new UserContent();
                    $userContent->user_id = Yii::$app->user->getId();
                    $userContent->content_id = $content['id'];
                    $userContent->save();
                }
                return $this->redirect(['content/']);
            }

        }


        return $this->render('view', [
            'content' => $content,
            'contentSpans' => $contentSpans,
            'contentSpansBySentences' => $contentSpansBySentences,
            'selectedSpanOriginals' => $selectedSpanOriginals,
            'selectedSpanTranslations' => $selectedSpanTranslations
        ]);
    }

    public function actionNew()
    {
        if (!in_array(Yii::$app->user->getIdentity()->status, [User::STATUS_AUTHOR, User::STATUS_ADMIN]))
            return $this->redirect(['content/']);
        $contentNewForm = new ContentNewForm();
        if (Yii::$app->request->isPost)
        {
            $contentNewForm->load(Yii::$app->request->post());
            $imageFile = UploadedFile::getInstance($contentNewForm, 'image');
            if ($contentNewForm->validate())
            {
                $content = new Content();
                $content->name = $contentNewForm->name;
                $content->complexity = $contentNewForm->complexity;
                $content->course_id = Yii::$app->user->getIdentity()->course_id;
                if ($content->save())
                {
                    if ($imageFile)
                        $content->setImage($imageFile);
                    $contentNewForm->text = preg_replace('/[\r\n]+/', "\r\n", $contentNewForm->text);
                    $paragraphs = explode(PHP_EOL, $contentNewForm->text);
                    $sentLens = json_decode($this->breakSentence($contentNewForm->text), true)[0]['sentLen'];
                    $sentences = [];
                    $sentencesCount = 1;
                    $lettersCount = 0;
                    $paragraphsCount = 0;
                    foreach ($sentLens as $index=>$value)
                    {
                        $sentences[$sentencesCount] = trim(substr($paragraphs[$paragraphsCount], $lettersCount, $value));
                        $sentencesCount++;
                        $lettersCount+=$value;
                        if($lettersCount >= strlen($paragraphs[$paragraphsCount]))
                        {
                            $paragraphsCount++;
                            $sentencesCount++;
                            $lettersCount = 0;
                        }
                    }
                    $words = [];
                    foreach ($sentences as $index=>$value)
                    {
                        $position = 1;
                        $sentenceParts = explode(' ', $value);

                        foreach ($sentenceParts as $sentencePart)
                        {
                            if (strlen(str_replace(' ', '', $sentencePart)) == 0)
                                continue;
                            $sentencePartArray = str_split_unicode(trim($sentencePart));
                            $prefixLength = 0;
                            $prefix = [];
                            $prefix['original'] = '';
                            foreach ($sentencePartArray as $i=>$symbol)
                            {
                                if(\IntlChar::isalpha($symbol))
                                {
                                    if($i > 0)
                                    {
                                        $prefix['sentence_position'] = $index;
                                        $prefix['translation'] = 0;
                                        $prefix['space_after'] = 0;
                                        $prefix['position'] = $position;
                                        $words[] = $prefix;
                                        $position++;
                                        $prefixLength = $i;
                                    }
                                    break;
                                }
                                else
                                {
                                    $prefix['original'] .= $symbol;
                                }
                            }
                            unset($prefix);

                            $suffixStart = count($sentencePartArray);
                            $suffix = [];
                            $suffix['original'] = '';
                            for ($i = count($sentencePartArray)-1; $i >= $prefixLength; $i--)
                            {
                                if(\IntlChar::isalpha($sentencePartArray[$i]))
                                {
                                    if($i < count($sentencePartArray)-1)
                                    {
                                        $suffix['sentence_position'] = $index;
                                        $suffix['translation'] = 0;
                                        $suffix['space_after'] = 1;
                                        $suffix['position'] = $position + 1;
                                        $suffixStart = $i;
                                    }
                                    break;
                                }
                                else
                                {
                                    $suffix['original'] = $sentencePartArray[$i].$suffix['original'];
                                }
                            }
                            $word = [];
                            $word['sentence_position'] = $index;
                            $word['translation'] = 1;
                            $word['space_after'] = 0;
                            $word['position'] = $position;
                            for($i = $prefixLength; $i <= $suffixStart; $i++)
                                $word['original'] .= $sentencePartArray[$i];
                            if ($suffixStart == count($sentencePartArray))
                                $word['space_after'] = 1;
                            $words[] = $word;
                            $position++;
                            if ($suffixStart < count($sentencePartArray))
                            {
                                $words[] = $suffix;
                                $position++;
                            }
                        }
                    }
                    $contentSpans = [];
                    foreach ($words as $word)
                    {
                        $tempContentSpan = new ContentSpan();
                        $tempContentSpan->sentence_position = $word['sentence_position'];
                        $tempContentSpan->position = $word['position'];
                        $tempContentSpan->space_after = $word['space_after'];
                        $tempContentSpan->original = $word['original'];
                        $tempContentSpan->translation = $word['translation'];
                        $tempContentSpan->content_id = $content->id;
                        $contentSpans[] = $tempContentSpan;
                    }
                    if (ActiveRecord::validateMultiple($contentSpans))
                    {
                        foreach ($contentSpans as $contentSpan)
                            $contentSpan->save();
                        return $this->redirect(['content/view', 'c'=>$content->id]);
                    }
                }
            }

        }
        return $this->render('new', [
            'contentNewForm' => $contentNewForm,
        ]);
    }

    public function actionEdit()
    {
        $user = User::findOne(Yii::$app->user->getId());
        $content = Content::findOne(Yii::$app->request->get('c'));
        if (!(in_array($user->status, [User::STATUS_AUTHOR, User::STATUS_ADMIN]) and Yii::$app->request->get('c') and $content))
            return $this->redirect(['content/']);
        $contentNewForm = new ContentNewForm();
        $text = '';
        if (Yii::$app->request->isPost and $contentNewForm->load(Yii::$app->request->post()) and $contentNewForm->validate())
        {
            $text = Yii::$app->request->post('text');
            $imageFile = UploadedFile::getInstance($contentNewForm, 'image');
            if ($imageFile)
                $content->setImage($imageFile);
            if ($contentNewForm->name != $content->name)
                $content->name = $contentNewForm->name;
            if ($contentNewForm->text != $text)
            {
                $contentNewForm->text = preg_replace('/[\r\n]+/', "\r\n", $contentNewForm->text);
                $paragraphs = explode(PHP_EOL, $contentNewForm->text);
                $sentLens = json_decode($this->breakSentence($contentNewForm->text), true)[0]['sentLen'];
                $sentences = [];
                $sentencesCount = 1;
                $lettersCount = 0;
                $paragraphsCount = 0;
                foreach ($sentLens as $index=>$value)
                {
                    $sentences[$sentencesCount] = trim(substr($paragraphs[$paragraphsCount], $lettersCount, $value));
                    $sentencesCount++;
                    $lettersCount+=$value;
                    if($lettersCount >= strlen($paragraphs[$paragraphsCount]))
                    {
                        $paragraphsCount++;
                        $sentencesCount++;
                        $lettersCount = 0;
                    }
                }
                $words = [];
                foreach ($sentences as $index=>$value)
                {
                    $position = 1;
                    $sentenceParts = explode(' ', $value);
                    foreach ($sentenceParts as $sentencePart)
                    {
                        if (strlen(str_replace(' ', '', $sentencePart)) == 0)
                            continue;
                        $sentencePartArray = str_split_unicode(trim($sentencePart));
                        $prefixLength = 0;
                        $prefix = [];
                        $prefix['original'] = '';
                        foreach ($sentencePartArray as $i=>$symbol)
                        {
                            if(\IntlChar::isalpha($symbol))
                            {
                                if($i > 0)
                                {
                                    $prefix['sentence_position'] = $index;
                                    $prefix['translation'] = 0;
                                    $prefix['space_after'] = 0;
                                    $prefix['position'] = $position;
                                    $words[] = $prefix;
                                    $position++;
                                    $prefixLength = $i;
                                }
                                break;
                            }
                            else
                            {
                                $prefix['original'] .= $symbol;
                            }
                        }
                        unset($prefix);
                        $suffixStart = count($sentencePartArray);
                        $suffix = [];
                        $suffix['original'] = '';
                        for ($i = count($sentencePartArray)-1; $i >= $prefixLength; $i--)
                        {
                            if(\IntlChar::isalpha($sentencePartArray[$i]))
                            {
                                if($i < count($sentencePartArray)-1)
                                {
                                    $suffix['sentence_position'] = $index;
                                    $suffix['translation'] = 0;
                                    $suffix['space_after'] = 1;
                                    $suffix['position'] = $position + 1;
                                    $suffixStart = $i;
                                }
                                break;
                            }
                            else
                            {
                                $suffix['original'] = $sentencePartArray[$i].$suffix['original'];
                            }
                        }
                        $word = [];
                        $word['sentence_position'] = $index;
                        $word['translation'] = 1;
                        $word['space_after'] = 0;
                        $word['position'] = $position;
                        for($i = $prefixLength; $i <= $suffixStart; $i++)
                            $word['original'] .= $sentencePartArray[$i];
                        if ($suffixStart == count($sentencePartArray))
                            $word['space_after'] = 1;
                        $words[] = $word;
                        $position++;
                        if ($suffixStart < count($sentencePartArray))
                        {
                            $words[] = $suffix;
                            $position++;
                        }
                    }
                }
                $contentSpans = [];
                foreach ($words as $word)
                {
                    $tempContentSpan = new ContentSpan();
                    $tempContentSpan->sentence_position = $word['sentence_position'];
                    $tempContentSpan->position = $word['position'];
                    $tempContentSpan->space_after = $word['space_after'];
                    $tempContentSpan->original = $word['original'];
                    $tempContentSpan->translation = $word['translation'];
                    $tempContentSpan->content_id = $content->id;
                    $contentSpans[] = $tempContentSpan;
                }
                if (ActiveRecord::validateMultiple($contentSpans))
                {
                    ContentSpan::deleteAll(['content_id'=>$content->id]);
                    foreach ($contentSpans as $contentSpan)
                        $contentSpan->save();
                }
            }
            $content->save();
            return $this->redirect(['content/view', 'c'=>$content->id]);
        }
        $contentSpans = ContentSpan::find()->where(['content_id'=>$content->id])->asArray()->all();
        $contentSpansBySentences = ArrayHelper::index($contentSpans, 'position', 'sentence_position');
        $sentenceIds = array_unique(ArrayHelper::getColumn($contentSpans, 'sentence_position'));
        sort($sentenceIds);
        for($i = $sentenceIds[0]; $i <= $sentenceIds[count($sentenceIds)-1]; $i++)
        {
            if ($contentSpansBySentences[$i] == null)
                $contentSpansBySentences[$i] = 'empty';
        }
        ksort($contentSpansBySentences);
        foreach ($contentSpansBySentences as $sentence_position=>$sentence)
        {
            if($sentence == 'empty')
            {
                $text .= "\r\n";
                continue;
            }
            foreach ($sentence as $position=>$span)
            {
                $text .= $span['original'];

                if ($span['space_after']==true)
                    $text .= ' ';
            }
        }
        $contentNewForm->name = $content->name;
        $contentNewForm->complexity = $content->complexity;
        $contentNewForm->text = $text;
        $image = $content->image;
        return $this->render('edit', [
            'contentNewForm' => $contentNewForm,
            'image' => $image,
            'text' => $text
        ]);
    }

    public function actionAjaxGetTranslations($from, $to, $text)
    {
        if (Yii::$app->request->isAjax)
        {
            $subscription_key = "AZURE_SUBSCRIPTION_KEY";
            $endpoint = "https://laboskintranslator.cognitiveservices.azure.com/translator/text/v3.0";
            $path = "/dictionary/lookup?api-version=3.0";
            $params = '&from='.$from.'&to='.$to;
            if (!function_exists('com_create_guid')) {
                function com_create_guid() {
                    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
                        mt_rand( 0, 0xffff ),
                        mt_rand( 0, 0x0fff ) | 0x4000,
                        mt_rand( 0, 0x3fff ) | 0x8000,
                        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
                    );
                }
            }
            function Translate ($host, $path, $key, $params, $content) {
                $headers = "Content-type: application/json\r\n" .
                    "Content-length: " . strlen($content) . "\r\n" .
                    "Ocp-Apim-Subscription-Key: $key\r\n" .
                    "X-ClientTraceId: " . com_create_guid() . "\r\n";
                $options = array (
                    'http' => array (
                        'header' => $headers,
                        'method' => 'POST',
                        'content' => $content
                    )
                );
                $context  = stream_context_create ($options);
                $result = file_get_contents ($host . $path . $params, false, $context);
                return $result;
            }
            $requestBody = array (
                array (
                    'Text' => $text,
                ),
            );
            $content = json_encode($requestBody);
            $result = Translate ($endpoint, $path, $subscription_key, $params, $content);
            return $result;
        }
        else
            return false;
    }

    public function actionAjaxTranslate($from, $to, $text)
    {
        if (Yii::$app->request->isAjax)
        {
            $subscription_key = "AZURE_SUBSCRIPTION_KEY";
            $endpoint = "https://laboskintranslator.cognitiveservices.azure.com/translator/text/v3.0";
            $path = "/translate?api-version=3.0";
            $params = '&from='.$from.'&to='.$to;
            if (!function_exists('com_create_guid')) {
                function com_create_guid() {
                    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
                        mt_rand( 0, 0xffff ),
                        mt_rand( 0, 0x0fff ) | 0x4000,
                        mt_rand( 0, 0x3fff ) | 0x8000,
                        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
                    );
                }
            }
            function Translate ($host, $path, $key, $params, $content) {
                $headers = "Content-type: application/json\r\n" .
                    "Content-length: " . strlen($content) . "\r\n" .
                    "Ocp-Apim-Subscription-Key: $key\r\n" .
                    "X-ClientTraceId: " . com_create_guid() . "\r\n";
                $options = array (
                    'http' => array (
                        'header' => $headers,
                        'method' => 'POST',
                        'content' => $content
                    )
                );
                $context  = stream_context_create ($options);
                $result = file_get_contents ($host . $path . $params, false, $context);
                return $result;
            }
            $requestBody = array (
                array (
                    'Text' => $text,
                ),
            );
            $content = json_encode($requestBody);
            $result = Translate ($endpoint, $path, $subscription_key, $params, $content);
            return $result;
        }
        else
            return false;
    }

    public function breakSentence($text)
    {
        $subscription_key = "AZURE_SUBSCRIPTION_KEY";
        $endpoint = "https://laboskintranslator.cognitiveservices.azure.com/translator/text/v3.0";
        $path = "/breaksentence?api-version=3.0";
        if (!function_exists('com_create_guid')) {
            function com_create_guid() {
                return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                    mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
                    mt_rand( 0, 0xffff ),
                    mt_rand( 0, 0x0fff ) | 0x4000,
                    mt_rand( 0, 0x3fff ) | 0x8000,
                    mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
                );
            }
        }
        function Translate ($host, $path, $key, $content) {
            $headers = "Content-type: application/json\r\n" .
                "Content-length: " . strlen($content) . "\r\n" .
                "Ocp-Apim-Subscription-Key: $key\r\n" .
                "X-ClientTraceId: " . com_create_guid() . "\r\n";
            $options = array (
                'http' => array (
                    'header' => $headers,
                    'method' => 'POST',
                    'content' => $content
                )
            );
            $context  = stream_context_create ($options);
            $result = file_get_contents ($host . $path, false, $context);
            return $result;
        }
        $requestBody = array (
            array (
                'Text' => $text,
            ),
        );
        $content = json_encode($requestBody);
        $result = Translate ($endpoint, $path, $subscription_key, $content);
        return $result;
    }

    public function actionAjaxDeleteContent($id)
    {
        if(Yii::$app->request->isAjax and in_array(Yii::$app->user->getIdentity()->status, [User::STATUS_AUTHOR, User::STATUS_ADMIN]) and Content::findOne($id) )
            Content::findOne($id)->delete();
    }



}
