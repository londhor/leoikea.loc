<?php

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $assetsBundle \metronic\MetronicAsset */
/* @throw \Exception */

use yii\helpers\Html;
use metronic\widgets\Breadcrumbs;

$contentTitle = isset($this->params['contentTitle']) ? $this->params['contentTitle'] : $this->title;

?>
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
    <!-- BEGIN: Left Aside -->
    <?= $this->render('sidebar', ['assetsBundle' => $assetsBundle]) ?>
    <!-- END: Left Aside -->
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title"><?= Html::encode($contentTitle) ?></h3>
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <?= \metronic\widgets\Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>
</div>