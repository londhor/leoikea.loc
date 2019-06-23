<?php

/* @var $this \yii\web\View */
/* @var $footerArticles array */
/* @var $socialLinks array */
/* @var $contacts array */

use yii\helpers\Url;
use yii\helpers\Html;

?>
<footer id="footer">
    <div class="container footer-container">
        <h2 class="container-header">Контакти</h2>
        <div class="footer-content-wp">
            <?php if ($contacts) { ?>
                <div class="footer-box">
                    <?php if ($contacts['addresses']) { ?>
                        <div class="contacts-box">
                            <div class="contacts-box-icon ic-pin"></div>
                            <?php foreach ($contacts['addresses'] as $address) { ?>
                                <div class="contact-row">
                                    <div class="contact-link"><?= $address['address'] ?></div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php if ($contacts['phones']) { ?>
                        <div class="contacts-box">
                            <div class="contacts-box-icon ic-phone"></div>
                            <?php foreach ($contacts['phones'] as $phone) { ?>
                                <div class="contact-row">
                                    <a href="tel:<?= $phone['phone'] ?>" target="_blank" class="contact-link"><?= $phone['label'] ?></a>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php if ($contacts['emails']) { ?>
                        <div class="contacts-box">
                            <div class="contacts-box-icon ic-mail"></div>
                            <?php foreach ($contacts['emails'] as $email) { ?>
                                <div class="contact-row">
                                    <a href="mailto:<?= Html::encode($email['email']) ?>" target="_blank" class="contact-link"><?= Html::encode($email['email']) ?></a>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if ($footerArticles) { ?>
                <div class="footer-box">
                    <ul class="footer-menu">
                        <?php foreach ($footerArticles as $article) { ?>
                            <li><a href="<?= Url::to($article['url']) ?>"><?= Html::encode($article['label']) ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
            <?php if ($socialLinks) { ?>
                <div class="footer-box footer-box-bnts-wp">
                    <?php foreach ($socialLinks as $link) { ?>
                        <a href="<?= Url::to($link['url']) ?>" target="_blank" class="btn btn-sm <?= Html::encode($link['icon']) ?>"><?= Html::encode($link['label']) ?></a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</footer>