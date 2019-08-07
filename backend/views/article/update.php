<?php

/* @var $this \yii\web\View */
/* @var $model \common\models\Article|null */
/* @var $form ActiveForm */
/* @var $languages \frontend\components\multilang\LanguageInterface[] */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Статті';
$this->params['headTitle'] = 'Статті - ' . ($model->isNewRecord ? 'Створення' : 'Редагування');

$this->params['breadcrumbs'] = [
    ['url' => ['index'], 'label' => 'Список'],
    ['label' => ($model->isNewRecord ? 'Створення' : 'Редагування')],
];

\metronic\Metronic::registerJsFile($this, 'vendors/summernote/dist/summernote.min.js');
\metronic\Metronic::registerJsFile($this, 'assets/snippets/forms/summernote.js');

$horizontalOptions = ['options' => ['class' => 'form-group m-form__group row'], 'template' => "{label}\n{beginWrapper}\n{input}\n{error}\n{hint}\n{endWrapper}"];

?>
<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon m--hide">
                    <i class="la la-gear"></i>
                </span>
                <h3 class="m-portlet__head-text">
                    <?= ($model->isNewRecord ? 'Створення' : 'Редагування') . ' статті' ?>
                </h3>
            </div>
        </div>
    </div>
    <!--begin::Form-->
    <?php $form = ActiveForm::begin([
        'id' => 'ArticleUpdateForm',
        'layout' => 'horizontal',
        'options' => [
            'class' => 'm-form m-form--fit m-form--label-align-right',
        ]
    ]); ?>
        <div class="m-portlet__body">
            <div class="m-form__section m-form__section--first">
                <div class="m-form__heading">
                    <h3 class="m-form__heading-title">1. Інфо:</h3>
                </div>
                <div class="m-form__group">
                    <ul class="nav nav-tabs" role="tablist">
                        <?php foreach ($languages as $language) { ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $language->isCurrent() ? 'active' : '' ?>" data-toggle="tab" href="#" data-target="#language-tab-<?= $language->getCode() ?>">
                                    <i><img src="<?= $language->getFlag() ?>" alt="<?= $language->getCode() ?>" height="13"></i>
                                    <?= Html::encode($language->getNativeName()) ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="tab-content">
                    <?php foreach ($languages as $language) { ?>
                        <div class="tab-pane <?= $language->isCurrent() ? 'active' : '' ?>" id="language-tab-<?= $language->getCode() ?>" role="tabpanel">
                            <?= $form->field($model, $model->getLangAttributeName('title', $language), $horizontalOptions)
                                ->textInput(['autofocus' => true, 'maxlenght' => true]) ?>
                            <?= $form->field($model, $model->getLangAttributeName('meta_title', $language), $horizontalOptions)
                                ->textInput(['maxlenght' => true]) ?>
                            <?= $form->field($model, $model->getLangAttributeName('meta_description', $language), $horizontalOptions)
                                ->textarea(['rows' => 5]) ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="m-form__seperator m-form__seperator--dashed m--margin-top-20 m--margin-bottom-20"></div>
                <?= $form->field($model, 'slug', $horizontalOptions)->textInput(['maxlenght' => true]) ?>
                <div class="m-form__seperator m-form__seperator--dashed m--margin-top-40 m--margin-bottom-40 m--visible-tablet-and-mobile"></div>
            </div>
            <div class="m-form__section m-form__section--last">
                <div class="m-form__heading">
                    <h3 class="m-form__heading-title">2. Опис:</h3>
                </div>
                <?php //= $form->field($model, 'body', $horizontalOptions)->widget(\mihaildev\ckeditor\CKEditor::className(), [
                //    'editorOptions' => \mihaildev\elfinder\ElFinder::ckeditorOptions('elfinder', [
                //        'preset' => 'small',
                //        'inline' => false,
                //    ]),
                //]); ?>
                <div class="m-form__group">
                    <ul class="nav nav-tabs" role="tablist">
                        <?php foreach ($languages as $language) { ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $language->isCurrent() ? 'active' : '' ?>" data-toggle="tab" href="#" data-target="#language-tab2-<?= $language->getCode() ?>">
                                    <i><img src="<?= $language->getFlag() ?>" alt="<?= $language->getCode() ?>" height="13"></i>
                                    <?= Html::encode($language->getNativeName()) ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="tab-content">
                    <?php foreach ($languages as $language) { ?>
                        <div class="tab-pane <?= $language->isCurrent() ? 'active' : '' ?>" id="language-tab2-<?= $language->getCode() ?>" role="tabpanel">
                            <?= $form->field($model, $model->getLangAttributeName('body', $language), $horizontalOptions)->textarea(['class' => 'summernote']) ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="m-portlet__foot m-portlet__foot--fit text-center">
            <div class="m-form__actions m-form__actions">
                <button type="submit" class="btn btn-primary">Зберегти</button>
                <button type="submit" class="btn btn-outline-primary m-btn m-btn--outline-2x" name="afterSave" value="saveAndClose">Зберегти і закрити</button>
                    <?= Html::a('Скасувати', ['index'], ['class' => 'btn btn-secondary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
    <!--end::Form-->
</div>


