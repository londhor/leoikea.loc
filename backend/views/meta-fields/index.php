<?php

/* @var $this yii\web\View */
/* @var $model backend\forms\MetaFieldsForm|null */
/* @var $form ActiveForm */
/* @var $languages \frontend\components\multilang\LanguageInterface[] */

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
                        <?php $lang = $language->getDatabaseCode() ?>
                        <div class="form-group form-group-last row">
                            <label  class="col-md-2 col-form-label">Головна сторінка</label>
                            <div class="col-md-6">
                                <?= $form->field($model, "homeTitle_$lang")
                                    ->label(false)
                                    ->textInput(['placeholder' => $model->getAttributeLabel("homeTitle_$lang")]) ?>
                                <?= $form->field($model, "homeDescription_$lang")
                                    ->label(false)
                                    ->textarea(['placeholder' => $model->getAttributeLabel("homeDescription_$lang")]) ?>
                            </div>
                            <div class="col-md-3">
                                <code>{{site_name}}</code> - Назва сайту<br>
                            </div>
                        </div>
                        <div class="m-form__seperator m-form__seperator--dashed m--margin-top-20 m--margin-bottom-20"></div>
                        <div class="form-group form-group-last row">
                            <label  class="col-md-2 col-form-label">Сторінка каталогу</label>
                            <div class="col-md-6">
                                <?= $form->field($model, "catalogTitle_$lang")
                                    ->label(false)
                                    ->textInput(['placeholder' => $model->getAttributeLabel("catalogTitle_$lang")]) ?>
                                <?= $form->field($model, "catalogDescription_$lang")
                                    ->label(false)
                                    ->textarea(['placeholder' => $model->getAttributeLabel("catalogDescription_$lang")]) ?>
                            </div>
                            <div class="col-md-3">
                                <code>{{site_name}}</code> - Назва сайту<br>
                            </div>
                        </div>
                        <div class="m-form__seperator m-form__seperator--dashed m--margin-top-20 m--margin-bottom-20"></div>
                        <div class="form-group form-group-last row">
                            <label  class="col-md-2 col-form-label">Пошук</label>
                            <div class="col-md-6">
                                <?= $form->field($model, "searchTitle_$lang")
                                    ->label(false)
                                    ->textInput(['placeholder' => $model->getAttributeLabel("searchTitle_$lang")]) ?>
                                <?= $form->field($model, "searchDescription_$lang")
                                    ->label(false)
                                    ->textarea(['placeholder' => $model->getAttributeLabel("searchDescription_$lang")]) ?>
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
                                <?= $form->field($model, "categoryTitle_$lang")
                                    ->label(false)
                                    ->textInput(['placeholder' => $model->getAttributeLabel("categoryTitle_$lang")]) ?>
                                <?= $form->field($model, "categoryDescription_$lang")
                                    ->label(false)
                                    ->textarea(['placeholder' => $model->getAttributeLabel("categoryDescription_$lang")]) ?>
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
                                <?= $form->field($model, "productTitle_$lang")
                                    ->label(false)
                                    ->textInput(['placeholder' => $model->getAttributeLabel("productTitle_$lang")]) ?>
                                <?= $form->field($model, "productDescription_$lang")
                                    ->label(false)
                                    ->textarea(['placeholder' => $model->getAttributeLabel("productDescription_$lang")]) ?>
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
                                <?= $form->field($model, "informationTitle_$lang")
                                    ->label(false)
                                    ->textInput(['placeholder' => $model->getAttributeLabel("informationTitle_$lang")]) ?>
                                <?= $form->field($model, "informationDescription_$lang")
                                    ->label(false)
                                    ->textarea(['placeholder' => $model->getAttributeLabel("informationDescription_$lang")]) ?>
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
                                <?= $form->field($model, "contactsTitle_$lang")
                                    ->label(false)
                                    ->textInput(['placeholder' => $model->getAttributeLabel("contactsTitle_$lang")]) ?>
                                <?= $form->field($model, "contactsDescription_$lang")
                                    ->label(false)
                                    ->textarea(['placeholder' => $model->getAttributeLabel("contactsDescription_$lang")]) ?>
                            </div>
                            <div class="col-md-3">
                                <code>{{site_name}}</code> - Назва сайту<br>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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