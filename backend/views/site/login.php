<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\forms\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use metronic\Metronic;

$this->title = 'Вхід';
$this->params['breadcrumbs'][] = $this->title;

Metronic::registerJsFile($this, 'assets/snippets/pages/site/login.js');

?>
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url(<?= Metronic::getAssetsUrl($this) ?>/assets/img/bg/bg-3.jpg);">
    <div class="m-grid__item m-grid__item--fluid m-login__wrapper">
        <div class="m-login__container">
            <div class="m-login__logo">
                <a href="#">
                    <img src="<?= Metronic::getAssetsUrl($this, '/assets/img/logos/logo-1.png') ?>">
                </a>
            </div>
            <div class="m-login__signin">
                <div class="m-login__head">
                    <h3 class="m-login__title">Вхід до Адмін-панелі</h3>
                </div>
                <?= Html::beginForm('', 'post', [
                    'class' => 'm-login__form m-form',
                    'id' => 'm_login_signin_form'
                ]) ?>
                    <div class="form-group m-form__group">
                        <input class="form-control m-input" type="text" placeholder="Email" name="LoginForm[username]"
                               autocomplete="off" value="<?= $model->username ?: '' ?>">
                    </div>
                    <div class="form-group m-form__group">
                        <input class="form-control m-input m-login__form-input--last" type="password"
                               placeholder="Пароль" name="LoginForm[password]">
                    </div>
                    <div class="row m-login__form-sub">
                        <input type="hidden" value="0" name="LoginForm[rememberMe]">
                        <div class="col m--align-left m-login__form-left">
                            <label class="m-checkbox  m-checkbox--focus">
                                <input type="checkbox" <?= $model->rememberMe ? 'checked' : '' ?> name="LoginForm[rememberMe]" value="1"> Запам'ятати мене
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="m-login__form-action">
                        <button id="m_login_signin_submit"
                                class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                            Увійти
                        </button>
                    </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
</div>