<?php

/* @var $this \yii\web\View */
/* @var $model \common\models\Reviews|null */
/* @var $form ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Відгуки клієнтів';
$this->params['headTitle'] = 'Відгуки клієнтів - ' . ($model->isNewRecord ? 'Новий відгук' : 'Редагування');

$this->params['breadcrumbs'] = [
    ['label' => 'Контент блоки'],
    ['label' => 'Відгуки клієнтів', 'url' => ['index']],
    ['label' => ($model->isNewRecord ? 'Новий відгук' : 'Редагування')]
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
                    <?= ($model->isNewRecord ? 'Новий відгук' : 'Редагування') ?>
                </h3>
            </div>
        </div>
    </div>
    <!--begin::Form-->
    <?php $form = ActiveForm::begin([
        'id' => 'ReviewsUpdateForm',
        'layout' => 'horizontal'
    ]); ?>
        <div class="m-portlet__body">
            <div class="m-form__section m-form__section--first">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <ipnut type="hidden" name="Reviews[active]" value="1"></ipnut>
                        <?= $form->field($model, 'upload', $horizontalOptions)->fileInput(['class' => 'custom-file-input'])->render(function ($field) use ($model) {
                            /** @var \yii\widgets\ActiveField $field */
                            $field->label();
                            $field->error();
                            $field->hint(null);
                            $field->parts['{innerLabel}'] = Html::label(
                                'Виберіть файл',
                                Html::getInputId($model, 'upload'),
                                ['class' => 'custom-file-label']
                            );
                            $field->parts['{preview}'] = Html::img(
                                $model->imageUrl,
                                ['style' => $model->image === null ? 'display: none;' : null, 'class' => 'img-fluid img-upload-preview']
                            );
                            $template = "{label}\n<div class=\"col-lg-8 col-md-8 col-sm-12\">\n<div class=\"custom-file\">\n{input}\n{innerLabel}\n</div>\n{hint}\n{error}\n{preview}\n</div>";
                            return strtr($template, $field->parts);
                        }) ?>
                        <?= $form->field($model, 'sort_order', $horizontalOptions)->textInput() ?>
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
                        <button type="submit" class="btn btn-outline-primary m-btn m-btn--outline-2x" name="afterSave" value="saveAndClose">Зберегти і закрити</button>
                        <?= Html::a('Скасувати', ['index'], ['class' => 'btn btn-secondary']) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
    <!--end::Form-->
</div>
<?php

$this->registerJs(<<<JS
$("#reviews-upload").change(function() {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        var preview = $(this).parents('.form-group:first').find('.img-upload-preview');

        reader.onload = function(e) {
            preview.attr('src', e.target.result).show();
        }
        
        reader.readAsDataURL(this.files[0]);
    }
});
JS
);

?>


