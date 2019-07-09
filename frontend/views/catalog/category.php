<?php

/* @var $this \yii\web\View */
/* @var $products \common\models\shop\Product[] */
/* @var $category \common\models\shop\Category */
/* @var $pager \yii\data\Pagination */
/* @var $subCategories \common\models\shop\Category[] */

use yii\helpers\Url;
use yii\helpers\Html;

?>
<article class="page-article">
    <div class="container page-container">
        <div class="breadcrubs-wp">
            <div class="breadcrubs">
                <a href="<?= Url::to(['/site/index']) ?>" class="ic-arrow-right breadcrubs-element"><?= Yii::t('app', 'Головна') ?></a>
                <a href="<?= Url::to(['/catalog/index']) ?>" class="ic-arrow-right breadcrubs-element"><?= Yii::t('app', 'Каталог') ?></a>
                <?php if ($category->parentCategory !== null) { ?>
                    <a href="<?= Url::to(['/catalog/category', 'path' => $category->parentCategory->slug]) ?>" class="ic-arrow-right breadcrubs-element"><?= $category->parentCategory->titleLang ?></a>
                <?php } ?>
                <a href="<?= Url::to(['/catalog/category', 'path' => $category->slug]) ?>" class="ic-arrow-right breadcrubs-element breadcrubs-element-current"><?= $category->titleLang ?></a>
            </div>
        </div>

        <h1 class="container-header"><?= $category->titleLang ?></h1>
        <?php if ($subCategories) { ?>
            <ul style="display: none;">
            <?php foreach ($subCategories as $subCategory) { ?>
                <li><a href="<?= Url::to(['catalog/category', 'path' => $subCategory->slug]) ?>"><?= Html::encode($subCategory->titleLang) ?></a></li>
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
        <?php if (!$products) { ?>
            <div class="page404-wp min">
                <div class="page404-icon ic-ben-5"></div>
                <div class="page404-subheader"><?= Yii::t('app', 'На жаль в даній категорії зараз відсутні товари. Можливо вас зацікавлять наступні пропозиції') ?></div>
            </div>
            <?= \frontend\widgets\PopularProductsWidget::widget([
                'detailUrl' => ['/catalog/index'],
                'detailTitle' => Yii::t('app', 'В каталог'),
                'lastItemUrl' => $category->parentCategory === null ? ['/catalog/index'] : ['/catalog/category', 'path' => $category->parentCategory->slug],
                'lastItemTitle' => $category->parentCategory === null ?
                    Yii::t('app', 'В каталог') :
                    Yii::t('app', 'Переглянути категорію {category}', ['category' => $category->parentCategory->titleLang]),
            ]) ?>
        <?php } ?>
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
