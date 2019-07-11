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
        <form class="search-form search-form-page-search" action="<?= Url::to(['catalog/search']) ?>" method="get" @submit="$root.initSearch('searchpage');fbp('Search')">
            <preloader></preloader>
            <div class="input-wp search-form-input-wp">
                <input type="text" value="<?=Html::encode(Yii::t('app', '{query}', ['query' => $query])) ?>" name="query" class="search-form-input" required autofocus>
                <?php if (!$query): ?>
                    <label>Пошук...</label>
                <?php endif ?>
                <button class="btn ic-close search-reset-btn" type="reset"></button>
            </div>
            <button class="btn btn-row" type="submit">Пошук</button>
        </form>

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
                'prevPageCssClass' => 'pagi-btn-prev ic-arrow-left',
                'nextPageCssClass' => 'pagi-btn-next ic-arrow-right',
                'activePageCssClass' => 'pagi-btn-active',
            ]) ?>
        <?php } else { ?>
            <div class="page404-wp">
                <div class="page404-subheader"><?= Yii::t('app', 'Пошук по вашому запиту не дав результатів') ?></div>
                <a href="<?= Url::to(['/catalog/index']) ?>" class="btn"><?= Yii::t('app', 'В каталог') ?></a>
            </div>
        <?php } ?>
    </div>
</article>

<?php if (!$products) { ?>
    <?= \frontend\widgets\PopularProductsWidget::widget(['title' => Yii::t('app', 'Рекомендовані товари')]) ?>
<?php } ?>
