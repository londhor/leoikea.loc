<?php

/* @var $this \yii\web\View */
/* @var $model \backend\forms\AdvantagesForm|null */
/* @var $form ActiveForm */
/* @var $languages \frontend\components\multilang\LanguageInterface[] */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use backend\assets\IconsAsset;

$this->title = 'Переваги';

$this->params['breadcrumbs'] = [
    ['label' => 'Контент блоки'],
    ['label' => 'Переваги'],
];

\metronic\Metronic::registerJsFile($this, 'vendors/jquery.repeater/jquery.repeater.js');
IconsAsset::register($this);

?>
<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon m--hide">
                    <i class="la la-gear"></i>
                </span>
                <h3 class="m-portlet__head-text">
                    Редагування переваг
                </h3>
            </div>
        </div>
    </div>
    <!--begin::Form-->
    <?php $form = ActiveForm::begin([
        'id' => 'AdvantagesForm',
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
                        <?php $lang = $language->getDatabaseCode(); ?>
                        <input type="hidden" name="AdvantagesForm[<?= "advantages_$lang" ?>]" value="">
                        <div id="AdvantagesForm__advantages-<?= $language->getCode() ?>">
                            <div class="form-group form-group-last row">
                                <label  class="col-lg-2 col-form-label"><?= $model->getAttributeLabel("advantages_$lang") ?>:</label>
                                <div data-repeater-list="AdvantagesForm[<?= "advantages_$lang" ?>]" class="col-lg-10">
                                    <?php foreach ($model->{"advantages_$lang"} ?: [['icon' => '', 'label' => '']] as $key => $advantages) { ?>
                                        <div data-repeater-item class="form-group row align-items-center">
                                            <div class="col-md-4">
                                                <?php $hasError = $model->hasErrors("advantages_$lang.$key.icon") ?>
                                                <div class="m-form__group--inline <?= $hasError ? 'has-danger' : '' ?>">
                                                    <div class="m-form__label">
                                                        <label>Іконка:</label>
                                                    </div>
                                                    <div class="m-form__control">
                                                        <?= Html::dropDownList('[icon]', $advantages['icon'], IconsAsset::$icons, [
                                                            'class' => 'form-control',
                                                        ]) ?>
                                                    </div>
                                                    <?php if ($hasError) { ?>
                                                        <div class="form-control-feedback"><?= $model->getFirstError("advantages_$lang.$key.icon") ?></div>
                                                    <?php } ?>
                                                </div>
                                                <div class="d-md-none m-margin-b-10"></div>
                                            </div>
                                            <div class="col-md-4">
                                                <?php $hasError = $model->hasErrors("advantages_$lang.$key.label") ?>
                                                <div class="m-form__group--inline <?= $hasError ? 'has-danger' : '' ?>">
                                                    <div class="m-form__label">
                                                        <label class="m-label m-label--single">Перевага:</label>
                                                    </div>
                                                    <div class="m-form__control">
                                                        <input type="text" class="form-control" placeholder="Перевага" name="[label]" value="<?= Html::getAttributeValue($model, "advantages_{$lang}[$key][label]") ?>">
                                                    </div>
                                                    <?php if ($hasError) { ?>
                                                        <div class="form-control-feedback"><?= $model->getFirstError("advantages_$lang.$key.label") ?></div>
                                                    <?php } ?>
                                                </div>
                                                <div class="d-md-none m-margin-b-10"></div>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" data-repeater-delete="" class="btn-sm btn btn-danger btn-bold"><i class="la la-trash-o"></i>Delete</button>
                                            </div>
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

                    $advantagesInitEmpty = count($model->{"advantages_$lang"}) > 0 ? 'false' : 'true';
                    $langCode = $language->getCode();
                    $this->registerJs(<<<JS
                        $('#AdvantagesForm__advantages-$langCode').repeater({
                            initEmpty: $advantagesInitEmpty,
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