<?php

/** @var $this \yii\web\View */
/** @var $reviews \common\models\Reviews[] */
/** @var $reviewsLink string|null */

use yii\helpers\Html;

?>
<article class="feedback-article" id="feedback-article">
    <div class="container">
        <h2 class="container-header">Відгуки наших клієнтів</h2>
        <div class="swiper-container feedback-slider">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <?php foreach ($reviews as $review) { ?>
                    <div class="swiper-slide coub coub-16n9 feedback-slide">
                        <?= Html::img($review->imageUrl, ['class' => 'card']) ?>
                    </div>
                <?php } ?>
            </div>
            <div class="swiper-pagination-wp">
                <button type="button" class="swiper-pagi-btn-prev ic-arrow-left"></button>
                <div class="swiper-pagination"></div>
                <button type="button" class="swiper-pagi-btn-next ic-arrow-right"></button>
            </div>
            <?php if ($reviewsLink) { ?>
                <a href="<?= $reviewsLink ?>" target="blank" class="btn ic-instagram">Всі відгуки</a>
            <?php } ?>
        </div>
    </div>
</article>