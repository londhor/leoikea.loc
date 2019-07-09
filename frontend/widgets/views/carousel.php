<?php

/* @var $this \yii\web\View */
/* @var $products \common\models\shop\Product[] */
/* @var $title string */
/* @var $detailTitle string */
/* @var $detailUrl array|string */
/* @var $lastItemTitle array|string */
/* @var $lastItemUrl array|string */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<article>
    <div class="container">
        <h2 class="container-header"><?= Html::encode($title) ?></h2>
        <div class="swiper-container items-slider">
            <div class="swiper-wrapper">
                <?php foreach ($products as $product) { ?>
                    <?= \frontend\widgets\ProductWidget::widget([
                        'product' => $product,
                    ]) ?>
                <?php } ?>
                <?php if ($lastItemUrl !== null && $lastItemTitle !== null) { ?>
                    <div class="swiper-slide card items-slide item-card item-card-last-item">
                        <a href="<?= Url::to($lastItemUrl) ?>" class="item-card-link"></a>
                        <div class="item-card-icon ic-ben-5"></div>
                        <div class="item-card-text"><?= Html::encode($lastItemTitle) ?></div>
                    </div>
                <?php } ?>
            </div>
            <div class="swiper-pagination-wp">
                <button type="button" class="swiper-pagi-btn-prev ic-arrow-left"></button>
                <div class="swiper-pagination"></div>
                <button type="button" class="swiper-pagi-btn-next ic-arrow-right"></button>
            </div>
            <?php if ($detailUrl !== null && $detailTitle !== null) { ?>
                <a href="<?= Url::to($detailUrl) ?>" class="btn"><?= Html::encode($detailTitle) ?></a>
            <?php } ?>
        </div>
    </div>
</article>