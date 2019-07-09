<?php

/* @var $this \yii\web\View */
/* @var $model \backend\forms\SearchQueriesForm|null */
/* @var $form ActiveForm */

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
    <input type="hidden" name="SearchQueriesForm[queries]" value="">
    <div class="m-portlet__body">
        <div class="m-form__section m-form__section--first">
            <div id="SearchQueriesForm__queries">
                <div class="form-group form-group-last row">
                    <label  class="col-lg-2 col-form-label"><?= $model->getAttributeLabel('queries') ?>:</label>
                    <div data-repeater-list="SearchQueriesForm[queries]" class="col-lg-6">
                        <?php foreach ($model->queries ?: [''] as $key => $queries) { ?>
                            <?php $hasError = $model->hasErrors('queries.' . $key) ?>
                            <div data-repeater-item="" class="m--margin-bottom-10 <?= $hasError ? 'has-danger' : '' ?>">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="la la-search"></i></span>
                                    </div>
                                    <input type="queries" name="SearchQueriesForm[queries][]" class="form-control form-control-danger" placeholder="Введіть запит" value="<?= Html::getAttributeValue($model, 'queries[' . $key . ']') ?>">
                                    <div class="input-group-append">
                                        <button type="button" data-repeater-delete class="btn btn-danger btn-icon"><i class="la la-close"></i></button>
                                    </div>
                                </div>
                                <?php if ($hasError) { ?>
                                    <div class="form-control-feedback"><?= $model->getFirstError('queries.' . $key) ?></div>
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

$queriesInitEmpty = count($model->queries) > 0 ? 'false' : 'true';
$this->registerJs(<<<JS
$('#SearchQueriesForm__queries').repeater({
    initEmpty: $queriesInitEmpty,
});
JS
);

?>