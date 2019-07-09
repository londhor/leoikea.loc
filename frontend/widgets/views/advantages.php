<?php

/** @var $this \yii\web\View */
/** @var $advantages array */

use yii\helpers\Html;

?>
<article>
    <div class="container our-advantage-container">
        <h2 class="container-header">
            <?= Yii::t('app', 'Чому варто замовити доставку товарів з Ikea у нас') ?>
        </h2>
        <div class="our-advantages-container">
            <?php $index = 1; ?>
            <?php foreach ($advantages as $advantage) { ?>
                <div class="our-advantage-row">
                    <div class="our-advantage-num"><?= $index++ ?></div>
                    <div class="our-advantage-icon <?= Html::encode($advantage['icon']) ?>"></div>
                    <div class="our-advantage-text"><?= Html::encode($advantage['label']) ?></div>
                </div>
            <?php } ?>
        </div>
    </div>
</article>