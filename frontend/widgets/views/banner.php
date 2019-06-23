<?php

/** @var $this \yii\web\View */

use yii\helpers\Url;

?>
<article class="hero-article">
    <div class="container hero-container">
        <div class="hero-illustration"></div>
        <div class="hero-content">
            <div class="hero-header">
                Швидка доставка<br>товарів з&nbsp;Ікея
            </div>
            <div class="hero-subheader">
                Актуальні ціни та асортимент. Відправка товарів зі складу впродовж двох днів, та до двох тижнів з Ikea. 
            </div>
            <div class="hero-btns-wp">
                <button @click="modal('search')" class="btn btn btn-row btn-white hero-btn-search" type="button">Пошук товарів</button>
                <a href="<?= Url::to(['/catalog/index']) ?>" class="btn line btn-white hero-btn-catalog">В каталог</a>
            </div>
        </div>
    </div>
</article>