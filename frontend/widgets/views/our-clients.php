<?php

/** @var $this \yii\web\View */

?>
<article>
    <div class="container">
        <h2 class="container-header">Нам довіряють</h2>
        <div class="swiper-container our-clients-slider">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <?php $i=1; while ($i<15): ?>
                    <div class="swiper-slide card coub our-clients-slide">
                        <img src="/static/img/client-<?=$i?>.png">
                    </div>
                <?php $i++; endwhile; ?>
            </div>

            <div class="swiper-pagination"></div>
        </div>
    </div>
</article>