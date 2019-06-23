<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\widgets\CarouselWidget;

$this->title = $name;

?>
<article class="article page-article">
    <div class="container page-container">
        <div class="page404-wp">
            <div style="display: none;"><?= $name ?></div>
            <div style="display: none;"><?= $message ?></div>
            <div class="page404-icon ic-404"></div>
            <div class="page404-header"><?= $exception->statusCode ?></div>
            <div class="page404-subheader">Сторінку видалено чи переміщено по новій адресі</div>
            <a href="<?= Url::to(['/site/index']) ?>" class="btn">На головну</a>
        </div>
    </div>
</article>