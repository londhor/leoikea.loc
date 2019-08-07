<?php

/* @var $this \yii\web\View */
/* @var $model \backend\forms\BannerForm|null */
/* @var $form ActiveForm */
/* @var $languages \frontend\components\multilang\LanguageInterface[] */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Банер';

$this->params['breadcrumbs'] = [
    ['label' => 'Контент блоки'],
    ['label' => 'Банер'],
];

$horizontalOptions = [
    'options' => ['class' => 'form-group m-form__group row'],
    'template' => "{label}\n{beginWrapper}\n{input}\n{error}\n{hint}\n{endWrapper}",
    'horizontalCssClasses' => [
        'label' => 'col-form-label col-lg-4 col-sm-12',
        'wrapper' => 'col-lg-8 col-md-8 col-sm-12',
        'hint' => 'offset-md-4',
        'error' => 'offset-md-4',
    ]
];

?>
<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon m--hide">
                    <i class="la la-gear"></i>
                </span>
                <h3 class="m-portlet__head-text">
                    Редагування банеру на головній сторінці
                </h3>
            </div>
        </div>
    </div>
    <!--begin::Form-->
    <?php $form = ActiveForm::begin([
        'id' => 'BannerForm',
        'layout' => 'horizontal'
    ]); ?>
        <div class="m-portlet__body">
            <div class="m-form__section m-form__section--first">
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
                            <div class="row">
                                <div class="col-lg-6">
                                    <?= $form->field($model, 'title_' . $language->getDatabaseCode(), $horizontalOptions)
                                        ->textarea(['maxlength' => true, 'rows' => 2]) ?>
                                    <?= $form->field($model, 'description_' . $language->getDatabaseCode(), $horizontalOptions)
                                        ->textarea(['rows' => 4]) ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="m-form__seperator m-form__seperator--dashed m--margin-top-40 m--margin-bottom-40 m--visible-tablet-and-mobile"></div>
            </div>
        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions">
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-10">
                        <button type="submit" class="btn btn-primary">Зберегти</button>
                        <?= Html::a('Скасувати', ['index'], ['class' => 'btn btn-secondary']) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
    <!--end::Form-->
</div>