<?php

/* @var $this \yii\web\View */
/* @var $products \common\models\shop\Product[] */
/* @var $query string */
/* @var $pager \yii\data\Pagination */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<article class="page-article">
    <div class="container page-container">
        <h1 class="container-header">Пошук: <?= Html::encode($query) ?></h1>
        <?php if ($products) { ?>
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
        <?php } else { ?>
            <div class="page404-wp">
                <div class="page404-subheader">Пошук по вашому запиту не дав результатів</div>
                <a href="<?= Url::to(['/catalog/index']) ?>" class="btn">В каталог</a>
            </div>
        <?php } ?>
    </div>
</article>

<?php if (!$products) { ?>
    <?= \frontend\widgets\CarouselWidget::widget(['title' => 'Рекомендовані товари']) ?>
<?php } ?>
