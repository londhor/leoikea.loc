<?php

/* @var $this \yii\web\View */
/* @var $products \common\models\shop\Product[] */
/* @var $pager \yii\data\Pagination */

?>
<article class="page-article">
    <div class="container page-container">
        <h1 class="container-header">Каталог</h1>
        <div class="product-grid">
            <?php foreach ($products as $product) { ?>
                <?= \frontend\widgets\ProductWidget::widget([
                    'product' => $product
                ]) ?>
            <?php } ?>
        </div>
        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $pager,
            'options' => ['tag' => 'div', 'class' => 'pagination-wp'],
            'linkContainerOptions' => ['tag' => 'span', 'class' => 'pagi-btn'],
            'prevPageCssClass' => 'pagi-btn-prev ic-icon',
            'nextPageCssClass' => 'pagi-btn-next ic-icon',
            'activePageCssClass' => 'pagi-btn-active',
        ]) ?>
    </div>
</article>
