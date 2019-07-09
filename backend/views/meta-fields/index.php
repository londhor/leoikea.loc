<?php

/* @var $this yii\web\View */
/* @var $model backend\forms\MetaFieldsForm|null */
/* @var $form ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Метадані';

$this->params['breadcrumbs'] = [
    ['label' => 'Метадані'],
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
                    Редагування метаданих
                </h3>
            </div>
        </div>
    </div>
    <!--begin::Form-->
    <?php $form = ActiveForm::begin([
        'id' => 'MetaFieldsForm',
    ]); ?>
    <div class="m-portlet__body">
        <div class="m-form__section m-form__section--first">
            <div class="form-group form-group-last row">
                <label  class="col-md-2 col-form-label">Головна сторінка</label>
                <div class="col-md-6">
                    <?= $form->field($model, 'homeTitle')
                        ->label(false)
                        ->textInput(['placeholder' => $model->getAttributeLabel('homeTitle')]) ?>
                    <?= $form->field($model, 'homeDescription')
                        ->label(false)
                        ->textarea(['placeholder' => $model->getAttributeLabel('homeDescription')]) ?>
                </div>
                <div class="col-md-3">
                    <code>{{site_name}}</code> - Назва сайту<br>
                </div>
            </div>
            <div class="m-form__seperator m-form__seperator--dashed m--margin-top-20 m--margin-bottom-20"></div>
            <div class="form-group form-group-last row">
                <label  class="col-md-2 col-form-label">Сторінка каталогу</label>
                <div class="col-md-6">
                    <?= $form->field($model, 'catalogTitle')
                        ->label(false)
                        ->textInput(['placeholder' => $model->getAttributeLabel('catalogTitle')]) ?>
                    <?= $form->field($model, 'catalogDescription')
                        ->label(false)
                        ->textarea(['placeholder' => $model->getAttributeLabel('catalogDescription')]) ?>
                </div>
                <div class="col-md-3">
                    <code>{{site_name}}</code> - Назва сайту<br>
                </div>
            </div>
            <div class="m-form__seperator m-form__seperator--dashed m--margin-top-20 m--margin-bottom-20"></div>
            <div class="form-group form-group-last row">
                <label  class="col-md-2 col-form-label">Пошук</label>
                <div class="col-md-6">
                    <?= $form->field($model, 'searchTitle')
                        ->label(false)
                        ->textInput(['placeholder' => $model->getAttributeLabel('searchTitle')]) ?>
                    <?= $form->field($model, 'searchDescription')
                        ->label(false)
                        ->textarea(['placeholder' => $model->getAttributeLabel('searchDescription')]) ?>
                </div>
                <div class="col-md-3">
                    <code>{{site_name}}</code> - Назва сайту<br>
                    <code>{{query}}</code> - Пошуковий запит<br>
                </div>
            </div>
            <div class="m-form__seperator m-form__seperator--dashed m--margin-top-20 m--margin-bottom-20"></div>
            <div class="form-group form-group-last row">
                <label  class="col-md-2 col-form-label">Категорія</label>
                <div class="col-md-6">
                    <?= $form->field($model, 'categoryTitle')
                        ->label(false)
                        ->textInput(['placeholder' => $model->getAttributeLabel('categoryTitle')]) ?>
                    <?= $form->field($model, 'categoryDescription')
                        ->label(false)
                        ->textarea(['placeholder' => $model->getAttributeLabel('categoryDescription')]) ?>
                </div>
                <div class="col-md-3">
                    <code>{{site_name}}</code> - Назва сайту<br>
                    <code>{{title}}</code> - Назва категорії<br>
                </div>
            </div>
            <div class="m-form__seperator m-form__seperator--dashed m--margin-top-20 m--margin-bottom-20"></div>
            <div class="form-group form-group-last row">
                <label  class="col-md-2 col-form-label">Товар</label>
                <div class="col-md-6">
                    <?= $form->field($model, 'productTitle')
                        ->label(false)
                        ->textInput(['placeholder' => $model->getAttributeLabel('productTitle')]) ?>
                    <?= $form->field($model, 'productDescription')
                        ->label(false)
                        ->textarea(['placeholder' => $model->getAttributeLabel('productDescription')]) ?>
                </div>
                <div class="col-md-3">
                    <code>{{site_name}}</code> - Назва сайту<br>
                    <code>{{title}}</code> - Назва товару<br>
                    <code>{{description}}</code> - Опис товару<br>
                    <code>{{price}}</code> - Ціна<br>
                    <code>{{category}}</code> - Назва категорії<br>
                </div>
            </div>
            <div class="m-form__seperator m-form__seperator--dashed m--margin-top-20 m--margin-bottom-20"></div>
            <div class="form-group form-group-last row">
                <label  class="col-md-2 col-form-label">Інформаційна сторінка</label>
                <div class="col-md-6">
                    <?= $form->field($model, 'informationTitle')
                        ->label(false)
                        ->textInput(['placeholder' => $model->getAttributeLabel('informationTitle')]) ?>
                    <?= $form->field($model, 'informationDescription')
                        ->label(false)
                        ->textarea(['placeholder' => $model->getAttributeLabel('informationDescription')]) ?>
                </div>
                <div class="col-md-3">
                    <code>{{site_name}}</code> - Назва сайту<br>
                    <code>{{meta}}</code> (для Meta-title) - Назва статті, або meta-title статті якщо поле заповнено<br>
                    <code>{{meta}}</code> (для Meta-description) - meta-description статті ящко поле заповнено, або назва статті<br>
                </div>
            </div>
            <div class="m-form__seperator m-form__seperator--dashed m--margin-top-20 m--margin-bottom-20"></div>
            <div class="form-group form-group-last row">
                <label  class="col-md-2 col-form-label">Контакти</label>
                <div class="col-md-6">
                    <?= $form->field($model, 'contactsTitle')
                        ->label(false)
                        ->textInput(['placeholder' => $model->getAttributeLabel('contactsTitle')]) ?>
                    <?= $form->field($model, 'contactsDescription')
                        ->label(false)
                        ->textarea(['placeholder' => $model->getAttributeLabel('contactsDescription')]) ?>
                </div>
                <div class="col-md-3">
                    <code>{{site_name}}</code> - Назва сайту<br>
                </div>
            </div>
        </div>
    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions m-form__actions">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-10">
                    <button type="submit" class="btn btn-primary">Зберегти</button>
                    <?= Html::a('Скасувати', ['index'], ['class' => 'btn btn-secondary']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <!--end::Form-->
</div>