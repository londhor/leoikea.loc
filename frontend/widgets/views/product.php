<?php

/** @var $this \yii\web\View */
/** @var $product \common\models\shop\Product */
/** @var $discount \frontend\components\ProductDiscount */

use yii\helpers\Html;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;
$discount = Yii::$app->discount;

?>
<div class="swiper-slide card items-slide item-card">
    <a href="<?= Url::to(['/product/index', 'key' => $product->id]) ?>" class="item-card-link"></a>
    <?php if ($product->isNewProduct()) { ?>
        <div class="item-card-new">Новий</div>
    <?php } ?>
    <div class="coub item-card-img">
        <img src="<?= $product->bucket()->getFileUrl($product->image->path) ?>" alt="<?= Html::encode($product->productName) ?>">
    </div>
    <h3 class="item-card-title"><?= Html::encode($product->titleLang) ?></h3>
    <div class="item-card-subheader"><?= Html::encode($product->descrLang) ?></div>
    <div class="item-card-price-wp">
        <?php if ($discount->hasDiscount()) { ?>
            <div class="item-card-price"><?= $formatter->asDecimal($discount->calcPrice($product->priceInCurrency)) ?><span>&#8372;</span></div>
            <div class="item-card-price item-card-price-sale"><?= $formatter->asDecimal($product->priceInCurrency) ?><span>&#8372;</span></div>
        <?php } else { ?>
            <div class="item-card-price"><?= $formatter->asDecimal($product->priceInCurrency) ?><span>&#8372;</span></div>
        <?php } ?>
    </div>
</div>
