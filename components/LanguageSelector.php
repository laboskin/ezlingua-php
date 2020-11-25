<?php

namespace app\components;

use app\models\Course;
use app\models\Language;
use Yii;
use yii\base\BootstrapInterface;
use yii\web\Cookie;

class LanguageSelector implements BootstrapInterface
{
    public $supportedLanguages = ['en-US', 'ru-RU', 'es-ES'];
    public static $languages = ['en-US', 'ru-RU', 'es-ES'];

    public function bootstrap($app)
    {
        $cookieLanguage = Yii::$app->request->cookies->getValue('language', null);

        if(isset($cookieLanguage) and in_array($cookieLanguage, $this->supportedLanguages))
            Yii::$app->language = $cookieLanguage;
        else
        {
            if (Yii::$app->user->isGuest)
                $preferredLanguage = Yii::$app->request->getPreferredLanguage($this->supportedLanguages);
            else
                $preferredLanguage = Language::findOne((Course::findOne(Yii::$app->user->getId())->original_language_id))->yii_code;
            Yii::$app->language = $preferredLanguage;
            Yii::$app->response->cookies->add(new Cookie([
                'name' => 'language',
                'value' => $preferredLanguage,
                'expire' => time() + 60*60*24*365 // 1 year
            ]));
        }



        // TODO: Implement bootstrap() method.
    }


}