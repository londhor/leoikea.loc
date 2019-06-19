<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Контакты';

?>
<article>
    <div class="container contacts-page-container">
        <h1 class="container-header">Контакты</h1>
        <div class="page-content">


            <div class="footer-box footer-box-contacts-page">

                <div class="contacts-box">
                    <div class="contacts-box-icon ic-phone"></div>
                    <div class="contact-row">
                        <a href="#" target="_blank" class="contact-link">+380 (99) <span>560 38 80</span></a>
                    </div>
                    <div class="contact-row">
                        <a href="#" target="_blank" class="contact-link">+380 (99) <span>560 38 80</span></a>
                    </div>
                </div>
                <div class="contacts-box">
                    <div class="contacts-box-icon ic-mail"></div>
                    <div class="contact-row">
                        <a href="#" target="_blank" class="contact-link">leoikea@gmail.com</a>
                    </div>
                </div>
                <div class="contacts-box">
                    <div class="contacts-box-icon ic-pin"></div>
                    <div class="contact-row">
                        <div class="contact-link">Улица Под Дубом 7Б,<br>Львов, Львовская область,<br>79000</div>
                    </div>
                </div>
            </div>

            <div class="card coub google-map-wp">
                <div class="google-map-placeholder">Идет загрузка карты...</div>
                <div id="google-map"></div>
            </div>

            <div class="footer-box">
                <ul class="footer-menu footer-menu-contacts">
                    <li><a href="#">Политика конфиденциальности</a></li>
                    <li><a href="#">Оплата и доставка</a></li>
                    <li><a href="#">Вопросы и ответы</a></li>
                </ul>
            </div>

            <div class="footer-box footer-box-bnts-wp">
                <a href="#" target="blank" class="btn btn-sm ic-facebook">Фейсбук</a>
                <a href="#" target="blank" class="btn btn-sm ic-instagram">Инстаграм</a>
            </div>
        </div>
    </div>
</article>