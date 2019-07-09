<?php

/** @var $this \yii\web\View */
/** @var $ourClients \common\models\OurClients[] */

use yii\helpers\Html;

?>
<article>
    <div class="container">
        <h2 class="container-header"><?= Yii::t('app', 'Нам довіряють') ?></h2>
        <div class="swiper-container our-clients-slider">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <?php foreach ($ourClients as $client) { ?>
                    <div class="swiper-slide card coub our-clients-slide">
                        <?= Html::img($client->imageUrl) ?>
                    </div>
                <?php } ?>
            </div>
            <div class="swiper-pagination-wp">
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</article>