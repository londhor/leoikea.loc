<?php

/* @var $this yii\web\View */

?>
<?= frontend\widgets\BannerWidget::widget() ?>
<?= frontend\widgets\AdvantagesWidget::widget() ?>
<?= frontend\widgets\OurClientsWidget::widget() ?>
<?= frontend\widgets\ReviewsWidget::widget() ?>
<?= frontend\widgets\PopularProductsWidget::widget([
    'detailUrl' => ['/catalog/index'],
    'detailTitle' => Yii::t('app', 'В каталог'),
    'lastItemUrl' => ['/catalog/index'],
    'lastItemTitle' => Yii::t('app', 'В каталог'),
]) ?>