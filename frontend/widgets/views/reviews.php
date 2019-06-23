<?php

/** @var $this \yii\web\View */

?>
<article class="feedback-article">
    <div class="container">
        <h2 class="container-header">Відгуки наших клієнтів</h2>
        <div class="swiper-container feedback-slider">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <?php $i=1; while ($i<=13): ?>
                    <div class="swiper-slide coub coub-16n9 feedback-slide">
                        <img class="card" src="/static/img/insta_feedback_<?=$i?>.jpg">
                    </div>
                <?php $i++; endwhile; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</article>