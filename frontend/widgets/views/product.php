<?php

/** @var $this \yii\web\View */
/** @var $product \common\models\shop\Product */
/** @var $priceSettings \frontend\components\PriceSettings */

use yii\helpers\Html;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;
$priceSettings = Yii::$app->priceSettings;

?>
<div class="swiper-slide card items-slide item-card">
    <a href="<?= Url::to(['/product/index', 'key' => $product->id]) ?>" class="item-card-link"></a>
    <div class="coub item-card-img">
        <?php if ($product->image) { ?>
            <img src="<?= $product->bucket()->getFileUrl($product->image->path) ?>" alt="<?= Html::encode($product->productName) ?>">
        <?php } else { ?>
            <div class="item-card-img-bg"><?= Yii::t('app', 'Зображення відсутнє...') ?></div>
        <?php } ?>
        <?php if ($product->isNewProduct()) { ?>
            <div class="item-card-new"><?= Yii::t('app/product', 'Новий') ?></div>
        <?php } ?>
    </div>
    <?php if ($title = Html::encode($product->titleLang)): ?>
    <h3 class="item-card-title"><?= $title ?></h3>
    <?php endif ?>
    <?php if ($description = mb_strimwidth(Html::encode($product->descrLang), 0, 32, "...")): ?>
    <div class="item-card-subheader">
        <?= $description ?>        
    </div>
    <?php endif ?>
    <div class="item-card-price-wp">
        <div class="item-card-price"><?= $formatter->asDecimal($priceSettings->calcDiscount($product->price,$product->category->id)) ?><span>&#8372;</span></div>
        <?php if ($priceSettings->hasDiscount()) { ?>
            <div class="item-card-price item-card-price-sale"><?= $formatter->asDecimal($priceSettings->calcPrice($product->price,$product->category->id)) ?><span>&#8372;</span></div>
        <?php } elseif ($product->old_price > $product->price) { ?>
            <div class="item-card-price item-card-price-sale"><?= $formatter->asDecimal($priceSettings->calcPrice($product->old_price,$product->category->id)) ?><span>&#8372;</span></div>
        <?php } ?>
    </div>
</div>
