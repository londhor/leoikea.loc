<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use metronic\Metronic;

$this->title = $name;

$code = $exception->statusCode;

if ($code == 404) {
    $message = 'На этой странице нечего делать.';
}

?>
<div class="m-grid__item m-grid__item--fluid m-grid m-error-4" style="background-image: url(<?= Metronic::getAssetsUrl($this) ?>/assets/img/error/bg4.jpg);">
    <div class="m-error_container">
        <h1 class="m-error_number">
            <?= $code ?>
        </h1>
        <p class="m-error_title">
            ERROR
        </p>
        <p class="m-error_description">
            <?= $message ?>
        </p>
    </div>
</div>
