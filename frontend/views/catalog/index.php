<?php

/* @var $this \yii\web\View */
/* @var $products \common\models\shop\Product[] */
/* @var $pager \yii\data\Pagination */
/* @var $categories \common\models\shop\Category[] */

use yii\helpers\Url;
use yii\helpers\Html;

?>
<article class="page-article">
    <div class="container page-container">
        <div class="breadcrubs-wp">
            <div class="breadcrubs">
                <a href="<?= Url::to(['/site/index']) ?>" class="ic-arrow-right breadcrubs-element"><?= Yii::t('app', 'Головна') ?></a>
                <a href="<?= Url::to(['/catalog/index']) ?>" class="ic-arrow-right breadcrubs-element breadcrubs-element-current"><?= Yii::t('app', 'Каталог') ?></a>
            </div>
        </div>
        <h1 class="container-header page-search-container-header"><?= Yii::t('app', 'Каталог') ?></h1>

        <?php if ($categories) { ?>
            <ul style="display: none;">
            <?php foreach ($categories as $category) { ?>
                <li>
                    <a href="<?= Url::to(['catalog/category', 'path' => $category->slug]) ?>" class="<?= Html::encode($category->icon) ?>">
                        <?= Html::encode($category->titleLang) ?>
                    </a>
                </li>
            <?php } ?>
            </ul>
        <?php } ?>

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
    </div>
</article>
