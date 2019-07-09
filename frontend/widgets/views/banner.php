<?php

/** @var $this \yii\web\View */
/** @var $title string */
/** @var $description string */

use yii\helpers\Url;

?>
<article class="hero-article">
    <div class="container hero-container">
        <div class="hero-illustration"></div>
        <div class="hero-content">
            <div class="hero-header">
                <?= $title ?>
            </div>
            <?php if ($description !== '') { ?>
                <div class="hero-subheader">
                    <?= $description ?>
                </div>
            <?php } ?>
            <div class="hero-btns-wp">
                <button @click="modal('search')" class="btn btn btn-row btn-white hero-btn-search" type="button"><?= Yii::t('app', 'Пошук товарів') ?></button>
                <a href="<?= Url::to(['/catalog/index']) ?>" class="btn line btn-white hero-btn-catalog"><?= Yii::t('app', 'В каталог') ?></a>
            </div>
        </div>
    </div>
</article>