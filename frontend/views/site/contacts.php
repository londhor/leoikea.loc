<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $addresses array */
/* @var $phones array */
/* @var $emails array */
/* @var $socials array */
/* @var $articles array */

use yii\helpers\Html;
use yii\helpers\Url;

$this->params['hideFooter'] = true;

?>
<article>
    <div class="container contacts-page-container">
        <h1 class="container-header"><?= Yii::t('app', 'Контакти') ?></h1>
        <div class="page-content">
            <div class="footer-box footer-box-contacts-page">
                <?php if ($phones) { ?>
                    <div class="contacts-box">
                        <div class="contacts-box-icon ic-phone"></div>
                        <?php foreach ($phones as $phone) { ?>
                            <div class="contact-row">
                                <a @click="fbp('Contact')" href="tel:<?= $phone['phone'] ?>" target="_blank" class="contact-link"><?= $phone['label'] ?></a>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if ($emails) { ?>
                    <div class="contacts-box">
                        <div class="contacts-box-icon ic-mail"></div>
                        <?php foreach ($emails as $email) { ?>
                            <div class="contact-row">
                                <a @click="fbp('Contact')" href="mailto:<?= Html::encode($email['email']) ?>" target="_blank" class="contact-link"><?= Html::encode($email['email']) ?></a>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if ($addresses) { ?>
                    <div class="contacts-box">
                        <div class="contacts-box-icon ic-pin"></div>
                        <?php foreach ($addresses as $address) { ?>
                            <div class="contact-row">
                                <div class="contact-link"><?= $address['address'] ?></div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>

            <div class="card coub google-map-wp">
                <div class="google-map-placeholder"><?= Yii::t('app', 'Завантаження карти...') ?></div>
                <a @click="fbp('Contact')" href="https://goo.gl/maps/2Q6ryuHDCV9PMnhh7" target="blank" id="google-map" title="<?=$addresses[0]['address']?>"></a>
            </div>

            <div class="page-contacts-footer-wp">
                <?php if ($articles) { ?>
                    <div class="footer-box">
                        <ul class="footer-menu footer-menu-contacts">
                            <?php foreach ($articles as $article) { ?>
                                <li><a href="<?= Url::to($article['url']) ?>"><?= Html::encode($article['label']) ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>

                <?php if ($socials) { ?>
                    <div class="footer-box footer-box-bnts-wp">
                        <?php foreach ($socials as $link) { ?>
                            <a @click="fbp('Social link click', {'social':'<?= Html::encode($link['label']) ?>'})" href="<?= Url::to($link['url']) ?>" target="_blank" class="btn btn-sm <?= Html::encode($link['icon']) ?>"><?= Html::encode($link['label']) ?></a>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</article>