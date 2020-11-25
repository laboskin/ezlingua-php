<?php

/* @var $this yii\web\View */
/* @var $countWordTranslation int */
/* @var $countTranslationWord int */
/* @var $countCards int */
/* @var $countAudio int */
/* @var $countConstructor int */


$this->title = Yii::t('trainingIndex', 'Training');
\app\assets\TrainingIndexAsset::register($this);

use yii\bootstrap\Html; ?>

<div class="main-container">
    <div class="page-title">
        <div class="page-name">
            <div class="page-name-text"><?= Yii::t('trainingIndex', 'Training') ?></div>
        </div>
        <div class="page-filter">
          <?= Html::beginForm('/training/', 'get', [
          ]); ?>
          <?= Html::dropDownList('v', Yii::$app->request->get('v'), \app\models\UserVocabulary::getUserVocabularySelect(), [
            'class'=> 'form-control',
            'onchange' => '$(this).closest("form").submit();',
            'prompt' => Yii::t('trainingIndex', 'All vocabularies')
          ]); ?>
          <?= Html::endForm(); ?>
        </div>
    </div>

    <div class="section">
        <div class="section-grid">
            <a class="training" href="<?= \yii\helpers\Url::to(['training/word-translation', 'v'=>Yii::$app->request->get('v')]) ?>">
                <div class="training-text">
                    <div class="training-title">
                      <?= Yii::t('trainingIndex', 'Word-translation') ?>
                    </div>
                    <div class="training-count">
                      <?= Yii::t(
                        'trainingIndex',
                        '{n, plural, =0{Not enough words} =1{# word} one{# words} few{# words} many{# words} other{# words}}',
                        ['n' => $countWordTranslation])
                      ?>
                    </div>
                </div>
                <div class="training-icon">
                    <svg viewBox="0 0 512 512">
                        <path style="fill:#cfd8dc;" d="M266.67,0h-256A10.67,10.67,0,0,0,0,10.67v256a10.67,10.67,0,0,0,10.67,10.66H245.33A10.66,10.66,0,0,0,256,266.67V256h10.67a10.67,10.67,0,0,0,10.66-10.67V10.67A10.67,10.67,0,0,0,266.67,0Z"/>
                        <path style="fill:#2196f3;" d="M245.33,234.67h256A10.67,10.67,0,0,1,512,245.33v256A10.67,10.67,0,0,1,501.33,512h-256a10.66,10.66,0,0,1-10.66-10.67v-256A10.66,10.66,0,0,1,245.33,234.67Z"/>
                        <path style="fill:#fafafa;" d="M202.67,106.67h-128a10.67,10.67,0,0,1,0-21.34h128a10.67,10.67,0,0,1,0,21.34Z"/>
                        <path style="fill:#fafafa;" d="M138.67,106.67A10.67,10.67,0,0,1,128,96V53.33a10.67,10.67,0,0,1,21.33,0V96A10.67,10.67,0,0,1,138.67,106.67Z"/>
                        <path style="fill:#fafafa;" d="M181.33,234.67a10.66,10.66,0,0,1-7.19-2.8C165.06,223.6,85.33,149.33,85.33,96a10.67,10.67,0,0,1,21.34,0c0,37.29,59.09,99.35,81.85,120.13a10.67,10.67,0,0,1-7.19,18.54Z"/>
                        <path style="fill:#fafafa;" d="M96,234.67a10.67,10.67,0,0,1-7.19-18.54c22.76-20.78,81.86-82.84,81.86-120.13A10.67,10.67,0,1,1,192,96c0,53.33-79.72,127.6-88.81,135.87A10.7,10.7,0,0,1,96,234.67Z"/>
                        <path style="fill:#fafafa;" d="M437.33,469.33a10.66,10.66,0,0,1-10-6.91l-54-144-54,144a10.67,10.67,0,0,1-20-7.51l64-170.67a11.1,11.1,0,0,1,20,0l64,170.67a10.67,10.67,0,0,1-6.23,13.74A10.26,10.26,0,0,1,437.33,469.33Z"/>
                        <path style="fill:#fafafa;" d="M416,426.67H330.67a10.67,10.67,0,0,1,0-21.34H416a10.67,10.67,0,0,1,0,21.34Z"/>
                        <path style="fill:#455a64;" d="M458.67,213.33A10.67,10.67,0,0,1,448,202.67,138.83,138.83,0,0,0,309.33,64a10.67,10.67,0,0,1,0-21.33,160.16,160.16,0,0,1,160,160A10.66,10.66,0,0,1,458.67,213.33Z"/>
                        <path style="fill:#455a64;" d="M458.67,213.33a10.67,10.67,0,0,1-7.56-3.11l-42.66-42.67a10.66,10.66,0,0,1,15.08-15.08l34,34,24.61-32.85a10.67,10.67,0,0,1,17.09,12.78l0,0-32,42.67a10.66,10.66,0,0,1-7.79,4.26Z"/>
                        <path style="fill:#455a64;" d="M202.67,469.33a160.16,160.16,0,0,1-160-160,10.67,10.67,0,0,1,21.33,0A138.83,138.83,0,0,0,202.67,448a10.67,10.67,0,0,1,0,21.33Z"/>
                        <path style="fill:#455a64;" d="M21.33,362.67A10.67,10.67,0,0,1,12.8,345.6l32-42.67a10.67,10.67,0,0,1,14.93-2.15,11,11,0,0,1,1.15,1l42.67,42.67a10.66,10.66,0,1,1-14.82,15.34l-.26-.26-34-34L29.87,358.4A10.68,10.68,0,0,1,21.33,362.67Z"/></svg>
                </div>
            </a>
            <a class="training" href="<?= \yii\helpers\Url::to(['training/translation-word', 'v'=>Yii::$app->request->get('v')]) ?>">
                <div class="training-text">
                    <div class="training-title">
                      <?= Yii::t('trainingIndex', 'Translation-word') ?>
                    </div>
                    <div class="training-count">
                      <?= Yii::t(
                        'trainingIndex',
                        '{n, plural, =0{Not enough words} =1{# word} one{# words} few{# words} many{# words} other{# words}}',
                        ['n' => $countTranslationWord])
                      ?>
                    </div>
                </div>
                <div class="training-icon">
                    <svg viewBox="0 0 512 512">
                        <path style="fill:#cfd8dc;" d="M266.67,0h-256A10.67,10.67,0,0,0,0,10.67v256a10.67,10.67,0,0,0,10.67,10.66H245.33A10.66,10.66,0,0,0,256,266.67V256h10.67a10.67,10.67,0,0,0,10.66-10.67V10.67A10.67,10.67,0,0,0,266.67,0Z"/>
                        <path style="fill:#2196f3;" d="M245.33,234.67h256A10.67,10.67,0,0,1,512,245.33v256A10.67,10.67,0,0,1,501.33,512h-256a10.66,10.66,0,0,1-10.66-10.67v-256A10.66,10.66,0,0,1,245.33,234.67Z"/>
                        <path style="fill:#fafafa;" d="M437.33,342h-128a10.67,10.67,0,0,1,0-21.33h128a10.67,10.67,0,1,1,0,21.33Z"/>
                        <path style="fill:#fafafa;" d="M373.33,342a10.66,10.66,0,0,1-10.66-10.66V288.65a10.67,10.67,0,1,1,21.33,0v42.67A10.67,10.67,0,0,1,373.33,342Z"/>
                        <path style="fill:#fafafa;" d="M416,470a10.63,10.63,0,0,1-7.19-2.79C399.72,458.91,320,384.65,320,331.32a10.67,10.67,0,1,1,21.33,0c0,37.29,59.1,99.35,81.86,120.13A10.66,10.66,0,0,1,416,470Z"/>
                        <path style="fill:#fafafa;" d="M330.67,470a10.66,10.66,0,0,1-7.19-18.53c22.76-20.78,81.85-82.84,81.85-120.13a10.67,10.67,0,0,1,21.34,0c0,53.33-79.73,127.59-88.81,135.87A10.65,10.65,0,0,1,330.67,470Z"/>
                        <path style="fill:#fafafa;" d="M202.67,234.34a10.67,10.67,0,0,1-10-6.91l-54-144-54,144a10.67,10.67,0,0,1-20-7.51l64-170.67a11.09,11.09,0,0,1,20,0l64,170.67a10.68,10.68,0,0,1-6.23,13.74A10.25,10.25,0,0,1,202.67,234.34Z"/>
                        <path style="fill:#fafafa;" d="M181.33,191.68H96a10.67,10.67,0,1,1,0-21.34h85.33a10.67,10.67,0,0,1,0,21.34Z"/>
                        <path style="fill:#455a64;" d="M458.67,213.33A10.67,10.67,0,0,1,448,202.67,138.83,138.83,0,0,0,309.33,64a10.67,10.67,0,0,1,0-21.33,160.16,160.16,0,0,1,160,160A10.66,10.66,0,0,1,458.67,213.33Z"/>
                        <path style="fill:#455a64;" d="M458.67,213.33a10.67,10.67,0,0,1-7.56-3.11l-42.66-42.67a10.66,10.66,0,0,1,15.08-15.08l34,34,24.61-32.85a10.67,10.67,0,0,1,17.09,12.78l0,0-32,42.67a10.66,10.66,0,0,1-7.79,4.26Z"/>
                        <path style="fill:#455a64;" d="M202.67,469.33a160.16,160.16,0,0,1-160-160,10.67,10.67,0,0,1,21.33,0A138.83,138.83,0,0,0,202.67,448a10.67,10.67,0,0,1,0,21.33Z"/>
                        <path style="fill:#455a64;" d="M21.33,362.67A10.67,10.67,0,0,1,12.8,345.6l32-42.67a10.67,10.67,0,0,1,14.93-2.15,11,11,0,0,1,1.15,1l42.67,42.67a10.66,10.66,0,1,1-14.82,15.34l-.26-.26-34-34L29.87,358.4A10.68,10.68,0,0,1,21.33,362.67Z"/></svg>
                </div>
            </a>
            <a class="training" href="<?= \yii\helpers\Url::to(['training/cards', 'v'=>Yii::$app->request->get('v')]) ?>">
                <div class="training-text">
                    <div class="training-title">
                      <?= Yii::t('trainingIndex', 'Cards') ?>
                    </div>
                    <div class="training-count">
                      <?= Yii::t(
                        'trainingIndex',
                        '{n, plural, =0{Not enough words} =1{# word} one{# words} few{# words} many{# words} other{# words}}',
                        ['n' => $countCards])
                      ?>
                    </div>
                </div>
                <div class="training-icon">
                    <svg viewBox="0 0 512 512">
                        <path d="m395.31 0h-169.08l-12.896 234.666 12.896 217.667h169.08c30.327 0 55-24.673 55-55v-342.333c0-30.327-24.673-55-55-55z" fill="#fdc673"/>
                        <path d="m176.23 0c-30.327 0-55 24.673-55 55v342.333c0 30.327 24.673 55 55 55h49.999v-452.333z" fill="#ffdf8e"/>
                        <path d="m335.769 59.667h-109.54l-12.896 236.374 12.896 215.959h109.54c30.327 0 55-24.673 55-55v-342.333c0-30.327-24.672-55-55-55z" fill="#e2e2ea"/>
                        <path d="m116.69 59.667c-30.327 0-55 24.673-55 55v342.333c0 30.327 24.673 55 55 55h109.539v-452.333z" fill="#f4f4f6"/><path d="m301.229 128h30v30h-30z" fill="#9ccefd"/>
                        <path d="m121.23 380.431h30v30h-30z" fill="#b0d8fd"/><path d="m226.229 454.936 40.563-24.91v-195.359h-40.563l-12.896 106.666z" fill="#a7a7c1"/><path d="m185.668 430.026 40.561 24.91v-220.269h-40.561z" fill="#bcbcd0"/>
                        <path d="m266.889 230.298v-111.301h-40.66l-12.896 62.336 12.896 48.965z" fill="#dc4b4b"/>
                        <path d="m185.571 118.997h40.658v111.301h-40.658z" fill="#e07037"/>
                        <path d="m292.735 197.676c-.286 13.209-11.267 23.956-24.479 23.956h-42.027l-12.896 13.034 12.896 16.966h42.027c14.331 0 27.864-5.521 38.107-15.544s16.054-23.435 16.363-37.763z" fill="#fdc673"/>
                        <path d="m184.203 221.632c-13.212 0-24.193-10.747-24.48-23.956l-29.992.649c.31 14.328 6.121 27.739 16.364 37.762 10.242 10.024 23.775 15.544 38.107 15.544h42.026v-30h-42.025z" fill="#ffdf8e"/></svg>
                </div>
            </a>
            <a class="training" href="<?= \yii\helpers\Url::to(['training/constructor', 'v'=>Yii::$app->request->get('v')]) ?>">
                <div class="training-text">
                    <div class="training-title">
                      <?= Yii::t('trainingIndex', 'Constructor') ?>
                    </div>
                    <div class="training-count">
                      <?= Yii::t(
                        'trainingIndex',
                        '{n, plural, =0{Not enough words} =1{# word} one{# words} few{# words} many{# words} other{# words}}',
                        ['n' => $countConstructor])
                      ?>
                    </div>
                </div>
                <div class="training-icon">
                    <svg viewBox="0 0 512 512">
                        <path style="fill:#FD3018;" d="M467,0H271c-8.291,0-15,6.709-15,15v62.904c-4.863-1.26-9.888-1.904-15-1.904
                        c-33.091,0-60,26.909-60,60s26.909,60,60,60c5.112,0,10.137-0.645,15-1.904V256l30,30h210.066L512,256V45
                        C512,20.147,491.853,0,467,0z"/>
                        <path style="fill:#1689FC;" d="M434.096,256c2.417-9.333,2.569-19.257,0.249-29.258c-5.118-22.059-23.659-39.972-45.851-44.473
                        C349.961,174.452,316,203.826,316,241c0,5.112,0.645,10.137,1.904,15H256l-30,15v224.134L256,512h211c24.853,0,45-20.147,45-45V256
                        H434.096z"/>
                        <path style="fill:#FEA832;" d="M271,316c-5.098,0-10.137,0.645-15,1.904V271v-15h-68.322c7.882,13.541,11.119,30.136,5.485,48.062
                        c-6.596,20.99-25.188,37.484-46.893,41.083C108.597,351.392,76,322.502,76,286c0-10.984,3.168-21.145,8.322-30H15
                        c-8.284,0-15,6.716-15,15v151v15v30c0,24.853,21.147,45,46,45h210v-75v-1.904c4.863,1.26,9.902,1.904,15,1.904
                        c33.091,0,60-27.909,60-61S304.091,316,271,316z"/></svg>

                </div>
            </a>
            <a class="training training-large" href="<?= \yii\helpers\Url::to(['training/audio', 'v'=>Yii::$app->request->get('v')]) ?>">
                <div class="training-text">
                    <div class="training-title">
                      <?= Yii::t('trainingIndex', 'Listening') ?>
                    </div>
                    <div class="training-count">
                      <?= Yii::t(
                        'trainingIndex',
                        '{n, plural, =0{Not enough words} =1{# word} one{# words} few{# words} many{# words} other{# words}}',
                        ['n' => $countAudio])
                      ?>
                    </div>
                </div>
                <div class="training-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 464 464">
                        <path style="fill:#ad7d4d;" d="M312,416h56v72H312Z" transform="translate(-24 -24)"/>
                        <path style="fill:#379ec3;" d="M432,248h48v56H432Z" transform="translate(-24 -24)"/>
                        <path style="fill:#379ec3;" d="M32,248H80v56H32Z" transform="translate(-24 -24)"/>
                        <path style="fill:#2f4054;" d="M96,264h0a24,24,0,0,1,24,24V432a24,24,0,0,1-24,24h0a24,24,0,0,1-24-24V288A24,24,0,0,1,96,264Z" transform="translate(-24 -24)"/>
                        <path style="fill:#2f4054;" d="M416,456h0a24,24,0,0,1-24-24V288a24,24,0,0,1,24-24h0a24,24,0,0,1,24,24V432A24,24,0,0,1,416,456Z" transform="translate(-24 -24)"/>
                        <path style="fill:#8acce7;" d="M40,248v-8C40,120.71,136.71,24,256,24h0c119.29,0,216,96.71,216,216v8H440v-8A184,184,0,0,0,256,56h0A184,184,0,0,0,72,240v8Z" transform="translate(-24 -24)"/>
                        <path style="fill:#349966;" d="M368,184V416H216v4a12,12,0,0,1-24,0v-4H180a36,36,0,0,0-36,36V220a36,36,0,0,1,36-36h12v4a12,12,0,0,0,24,0v-4Z" transform="translate(-24 -24)"/>
                        <path style="fill:#eedc9a;" d="M342.54,477.46A35.92,35.92,0,0,0,368,488H216v-4a12,12,0,0,0-24,0v4H180a36,36,0,0,1,0-72h12v4a12,12,0,0,0,24,0v-4H368a36,36,0,0,0-35.77,32,34.52,34.52,0,0,0,0,8,35.56,35.56,0,0,0,5.83,16A36.06,36.06,0,0,0,342.54,477.46Z" transform="translate(-24 -24)"/>
                        <path style="fill:#008051;" d="M216,188V420a12,12,0,0,1-24,0V188a12,12,0,0,0,24,0Z" transform="translate(-24 -24)"/>
                        <path style="fill:#eebe33;" d="M338.06,432a35.56,35.56,0,0,0-5.83,16H232V432Z" transform="translate(-24 -24)"/>
                        <path style="fill:#eebe33;" d="M338.06,472H232V456H332.23A35.56,35.56,0,0,0,338.06,472Z" transform="translate(-24 -24)"/>
                        <path style="fill:#8acce7;" d="M40,288H72V432H40a16,16,0,0,1-16-16V304A16,16,0,0,1,40,288Z" transform="translate(-24 -24)"/>
                        <path style="fill:#8acce7;" d="M472,432H440V288h32a16,16,0,0,1,16,16V416A16,16,0,0,1,472,432Z" transform="translate(-24 -24)"/></svg>
                </div>
            </a>

        </div>
    </div>




</div>

