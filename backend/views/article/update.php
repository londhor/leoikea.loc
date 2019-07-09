<?php

/* @var $this \yii\web\View */
/* @var $model \common\models\Article|null */
/* @var $form ActiveForm */

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
                <?= $form->field($model, 'title', $horizontalOptions)->textInput(['autofocus' => true, 'maxlenght' => true]) ?>
                <?= $form->field($model, 'meta_title', $horizontalOptions)->textInput(['maxlenght' => true]) ?>
                <?= $form->field($model, 'meta_description', $horizontalOptions)->textarea(['rows' => 5]) ?>
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
                <?= $form->field($model, 'body', $horizontalOptions)->textarea(['class' => 'summernote']) ?>
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


