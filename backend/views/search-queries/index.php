<?php

/* @var $this \yii\web\View */
/* @var $model \backend\forms\SearchQueriesForm|null */
/* @var $form ActiveForm */
/* @var $languages \frontend\components\multilang\LanguageInterface[] */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Пошукові запити';

$this->params['breadcrumbs'] = [
    ['label' => 'Контент блоки'],
    ['label' => 'Пошукові запити'],
];

\metronic\Metronic::registerJsFile($this, 'vendors/jquery.repeater/jquery.repeater.js');

?>
<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon m--hide">
                    <i class="la la-gear"></i>
                </span>
                <h3 class="m-portlet__head-text">
                    Редагування пошукових запитів
                </h3>
            </div>
        </div>
    </div>
    <!--begin::Form-->
    <?php $form = ActiveForm::begin([
        'id' => 'SearchQueriesForm',
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
                    <?php $langCode = $language->getCode() ?>
                    <?php $lang = $language->getDatabaseCode() ?>
                    <div class="tab-pane <?= $language->isCurrent() ? 'active' : '' ?>" id="language-tab-<?= $langCode ?>" role="tabpanel">
                        <input type="hidden" name="SearchQueriesForm[<?= "queries_$lang" ?>]" value="">
                        <div id="SearchQueriesForm__queries-<?= $langCode ?>">
                            <div class="form-group form-group-last row">
                                <label  class="col-lg-2 col-form-label"><?= $model->getAttributeLabel("queries_$lang") ?>:</label>
                                <div data-repeater-list="SearchQueriesForm[<?= "queries_$lang" ?>]" class="col-lg-6">
                                    <?php foreach ($model->{"queries_$lang"} ?: [''] as $key => $queries) { ?>
                                        <?php $hasError = $model->hasErrors("queries_$lang.$key") ?>
                                        <div data-repeater-item="" class="m--margin-bottom-10 <?= $hasError ? 'has-danger' : '' ?>">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="la la-search"></i></span>
                                                </div>
                                                <input type="text" name="SearchQueriesForm[<?= "queries_$lang" ?>][]" class="form-control form-control-danger" placeholder="Введіть запит" value="<?= Html::getAttributeValue($model, "queries_{$lang}[$key]") ?>">
                                                <div class="input-group-append">
                                                    <button type="button" data-repeater-delete class="btn btn-danger btn-icon"><i class="la la-close"></i></button>
                                                </div>
                                            </div>
                                            <?php if ($hasError) { ?>
                                                <div class="form-control-feedback"><?= $model->getFirstError("queries_$lang.$key") ?></div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group form-group-last row">
                                <label class="col-lg-2 col-form-label"></label>
                                <div class="col-lg-4">
                                    <button type="button" data-repeater-create class="btn btn-sm m-btn-bold btn-brand">
                                        <i class="la la-plus"></i> Додати
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php

                    $queriesInitEmpty = count($model->queries_ru) > 0 ? 'false' : 'true';
                    $this->registerJs(<<<JS
                        $('#SearchQueriesForm__queries-$langCode').repeater({
                            initEmpty: $queriesInitEmpty,
                        });
JS
                    );

                    ?>
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