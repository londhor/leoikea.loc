<?php

/* @var $this \yii\web\View */
/* @var $model \backend\forms\ContactsForm|null */
/* @var $form ActiveForm */
/* @var $languages \frontend\components\multilang\LanguageInterface[] */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use \backend\assets\IconsAsset;

$this->title = 'Контакти';

$this->params['breadcrumbs'] = [
    ['label' => 'Контакти']
];

\metronic\Metronic::registerJsFile($this, 'vendors/jquery.repeater/jquery.repeater.js');
IconsAsset::register($this);

$horizontalOptions = [
    'options' => ['class' => 'form-group m-form__group row'],
    'template' => "{label}\n{beginWrapper}\n{input}\n{error}\n{hint}\n{endWrapper}",
    'horizontalCssClasses' => [
        'label' => 'col-form-label col-lg-2 col-sm-12',
        'wrapper' => 'col-lg-6 col-md-6 col-sm-12',
        'hint' => 'offset-md-2',
        'error' => 'offset-md-2',
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
                    Редагування контактної інформації
                </h3>
            </div>
        </div>
    </div>
    <!--begin::Form-->
    <?php $form = ActiveForm::begin([
        'id' => 'ContactsForm',
        'layout' => 'horizontal'
    ]); ?>
    <input type="hidden" name="ContactsForm[email]" value="">
    <input type="hidden" name="ContactsForm[phone]" value="">
    <input type="hidden" name="ContactsForm[social]" value="">
        <div class="m-portlet__body">
            <div class="m-form__section m-form__section--first">
                <div id="ContactsForm__email">
                    <div class="form-group form-group-last row">
                        <label  class="col-lg-2 col-form-label"><?= $model->getAttributeLabel('email') ?>:</label>
                        <div data-repeater-list="ContactsForm[email]" class="col-lg-6">
                            <?php foreach ($model->email ?: [''] as $key => $email) { ?>
                                <?php $hasError = $model->hasErrors('email.' . $key) ?>
                                <div data-repeater-item="" class="m--margin-bottom-10 <?= $hasError ? 'has-danger' : '' ?>">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="la la-envelope"></i></span>
                                        </div>
                                        <input type="email" name="ContactsForm[email][]" class="form-control form-control-danger" placeholder="Введіть Email" value="<?= Html::getAttributeValue($model, 'email[' . $key . ']') ?>">
                                        <div class="input-group-append">
                                            <button type="button" data-repeater-delete class="btn btn-danger btn-icon"><i class="la la-close"></i></button>
                                        </div>
                                    </div>
                                    <?php if ($hasError) { ?>
                                        <div class="form-control-feedback"><?= $model->getFirstError('email.' . $key) ?></div>
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
                <div id="ContactsForm__phone">
                    <div class="form-group form-group-last row">
                        <label  class="col-lg-2 col-form-label"><?= $model->getAttributeLabel('phone') ?>:</label>
                        <div data-repeater-list="ContactsForm[phone]" class="col-lg-6">
                            <?php foreach ($model->phone ?: [''] as $key => $phone) { ?>
                                <?php $hasError = $model->hasErrors('phone.' . $key) ?>
                                <div data-repeater-item="" class="m--margin-bottom-10 <?= $hasError ? 'has-danger' : '' ?>">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="la la-phone"></i></span>
                                        </div>
                                        <input type="tel" name="ContactsForm[phone][]" class="form-control form-control-danger" placeholder="Введіть телефон" value="<?= Html::getAttributeValue($model, 'phone[' . $key . ']') ?>">
                                        <div class="input-group-append">
                                            <button type="button" data-repeater-delete class="btn btn-danger btn-icon"><i class="la la-close"></i></button>
                                        </div>
                                    </div>
                                    <?php if ($hasError) { ?>
                                        <div class="form-control-feedback"><?= $model->getFirstError('phone.' . $key) ?></div>
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
                            <input type="hidden" name="ContactsForm[<?= "address_$lang" ?>]" value="">
                            <div id="ContactsForm__address-<?= $langCode ?>">
                                <div class="form-group form-group-last row">
                                    <label  class="col-lg-2 col-form-label"><?= $model->getAttributeLabel("address_$lang") ?>:</label>
                                    <div data-repeater-list="ContactsForm[<?= "address_$lang" ?>]" class="col-lg-6">
                                        <?php foreach ($model->{"address_$lang"} ?: [''] as $key => $address) { ?>
                                            <?php $hasError = $model->hasErrors("address_$lang.$key") ?>
                                            <div data-repeater-item="" class="m--margin-bottom-10 <?= $hasError ? 'has-danger' : '' ?>">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="la la-map-o"></i></span>
                                                    </div>
                                                    <textarea name="ContactsForm[<?= "address_$lang" ?>][]" rows="2" class="form-control form-control-danger" placeholder="Введіть адресу"><?= Html::getAttributeValue($model, "address_{$lang}[$key]") ?></textarea>
                                                    <div class="input-group-append">
                                                        <button type="button" data-repeater-delete class="btn btn-danger btn-icon"><i class="la la-close"></i></button>
                                                    </div>
                                                </div>
                                                <?php if ($hasError) { ?>
                                                    <div class="form-control-feedback"><?= $model->getFirstError("address_$lang.$key") ?></div>
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

                        $addressInitEmpty = count($model->{"address_$lang"}) > 0 ? 'false' : 'true';
                        $this->registerJs(<<<JS
                            $('#ContactsForm__address-$langCode').repeater({
                                initEmpty: $addressInitEmpty,
                            });
JS
                        );

                        ?>
                    <?php } ?>
                </div>
                <div class="m-form__seperator m-form__seperator--dashed m--margin-top-40 m--margin-bottom-40"></div>
                <div id="ContactsForm__social">
                    <div class="form-group form-group-last row">
                        <label  class="col-lg-2 col-form-label"><?= $model->getAttributeLabel('social') ?>:</label>
                        <div data-repeater-list="ContactsForm[social]" class="col-lg-10">
                            <?php foreach ($model->social ?: [['icon' => '', 'label' => '', 'link' => '']] as $key => $social) { ?>
                            <div data-repeater-item class="form-group row align-items-center">
                                <div class="col-md-3">
                                    <?php $hasError = $model->hasErrors("social.$key.icon") ?>
                                    <div class="m-form__group--inline <?= $hasError ? 'has-danger' : '' ?>">
                                        <div class="m-form__label">
                                            <label>Іконка:</label>
                                        </div>
                                        <div class="m-form__control">
                                            <?= Html::dropDownList('[icon]', $social['icon'], IconsAsset::$icons, [
                                                'class' => 'form-control',
                                            ]) ?>
                                        </div>
                                        <?php if ($hasError) { ?>
                                            <div class="form-control-feedback"><?= $model->getFirstError("social.$key.icon") ?></div>
                                        <?php } ?>
                                    </div>
                                    <div class="d-md-none m-margin-b-10"></div>
                                </div>
                                <div class="col-md-3">
                                    <?php $hasError = $model->hasErrors("social.$key.label") ?>
                                    <div class="m-form__group--inline <?= $hasError ? 'has-danger' : '' ?>">
                                        <div class="m-form__label">
                                            <label class="m-label m-label--single">Позначка:</label>
                                        </div>
                                        <div class="m-form__control">
                                            <input type="text" class="form-control" placeholder="Позначка" name="[label]" value="<?= Html::getAttributeValue($model, "social[$key][label]") ?>">
                                        </div>
                                        <?php if ($hasError) { ?>
                                            <div class="form-control-feedback"><?= $model->getFirstError("social.$key.label") ?></div>
                                        <?php } ?>
                                    </div>
                                    <div class="d-md-none m-margin-b-10"></div>
                                </div>
                                <div class="col-md-3">
                                    <?php $hasError = $model->hasErrors("social.$key.link") ?>
                                    <div class="m-form__group--inline <?= $hasError ? 'has-danger' : '' ?>">
                                        <div class="m-form__label">
                                            <label class="m-label m-label--single">Посилання:</label>
                                        </div>
                                        <div class="m-form__control">
                                            <input type="text" class="form-control" placeholder="Посилання" name="[link]" value="<?= Html::getAttributeValue($model, "social[$key][link]") ?>">
                                        </div>
                                        <?php if ($hasError) { ?>
                                            <div class="form-control-feedback"><?= $model->getFirstError("social.$key.link") ?></div>
                                        <?php } ?>
                                    </div>
                                    <div class="d-md-none m-margin-b-10"></div>
                                </div>
                                <div class="col-md-3">
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
                <?= $form->field($model, 'reviewsLink', $horizontalOptions)->textInput(['placeholder' => 'Наприклад https://domain.com/all-reviews']) ?>
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
<?php

$emailInitEmpty = count($model->email) > 0 ? 'false' : 'true';
$phoneInitEmpty = count($model->phone) > 0 ? 'false' : 'true';
$socialInitEmpty = count($model->social) > 0 ? 'false' : 'true';

$this->registerJs(<<<JS
$('#ContactsForm__email').repeater({
    initEmpty: $emailInitEmpty,
});
$('#ContactsForm__phone').repeater({
    initEmpty: $phoneInitEmpty,
});
$('#ContactsForm__social').repeater({
    initEmpty: $socialInitEmpty,
});
JS
);

?>