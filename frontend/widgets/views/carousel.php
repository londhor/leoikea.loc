<?php

/* @var $this \yii\web\View */
/* @var $products \common\models\shop\Product[] */
/* @var $title string */

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
                <div class="swiper-slide card items-slide item-card item-card-last-item">
                    <a href="<?= Url::to(['/catalog/index']) ?>" class="item-card-link"></a>
                    <div class="item-card-icon ic-ben-5"></div>
                    <div class="btn sm line item-card-text">В каталог</div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
            <a href="<?= Url::to(['/catalog/index']) ?>" class="btn">В каталог</a>
        </div>
    </div>
</article>