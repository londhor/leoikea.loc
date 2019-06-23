<?php

/* @var $this \yii\web\View */
/* @var $product null|\common\models\shop\Product */
/* @var $discount \frontend\components\ProductDiscount */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;

$formatter = Yii::$app->formatter;
$discount = Yii::$app->discount;

?>
<article class="item-article">
    <div class="container item-container">
        <div class="breadcrubs">
            <a href="<?= Url::to(['/site/index']) ?>" class="ic-arrow-right breadcrubs-element">Головна</a>
            <?php if ($product->category->parentCategory !== null) { ?>
                <a href="<?= Url::to(['/catalog/category', 'path' => $product->category->parentCategory->slug]) ?>" class="ic-arrow-right breadcrubs-element"><?= $product->category->parentCategory->titleLang ?></a>
            <?php } ?>
            <a href="<?= Url::to(['/catalog/category', 'path' => $product->category->slug]) ?>" class="ic-arrow-right breadcrubs-element"><?= $product->category->titleLang ?></a>
            <a href="<?= Url::to(['/product/index', 'key' => $product->id]) ?>" class="ic-arrow-right breadcrubs-element breadcrubs-element-current"><?= $product->titleLang ?></a>
        </div>

        <div class="single-item-content-container">
            <div class="si-slider-container">
                <div class="swiper-container si-slider">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <?php foreach ($product->images as $image) { ?>
                            <div class="swiper-slide card coub si-slide">
                                <img src="<?= $product->bucket()->getFileUrl($image->path) ?>" alt="<?= Html::encode($product->productName) ?>">
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- si-thumbs если картинок более чем 1 шт -->
                <div class="swiper-container si-thumbs">
                    <div class="swiper-wrapper">
                        <?php foreach ($product->imagesZoom as $image) { ?>
                            <div class="swiper-slide card coub si-thumb">
                                <img src="<?= $product->bucket()->getFileUrl($image->path) ?>" alt="<?= Html::encode($product->productName) ?>">
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="si-main-content-wp">
                <div class="si-main-content-container">
                    <div class="si-main-content">
                        <div class="si-article"><span>Артикул</span><?= Html::encode($product->article) ?></div>
                        <h1 class="si-title"><?= Html::encode($product->titleLang) ?></h1>
                        <h2 class="si-subheader"><?= Html::encode($product->descrLang) ?></h2>
                        <div class="item-card-price-wp si-item-card-price-wp">
                            <?php if ($discount->hasDiscount()) { ?>
                                <div class="item-card-price"><?= $formatter->asDecimal($discount->calcPrice($product->priceInCurrency)) ?><span>&#8372;</span></div>
                                <div class="item-card-price item-card-price-sale"><?= $formatter->asDecimal($product->priceInCurrency) ?><span>&#8372;</span></div>
                            <?php } else { ?>
                                <div class="item-card-price"><?= $formatter->asDecimal($product->priceInCurrency) ?><span>&#8372;</span></div>
                            <?php } ?>
                        </div>
                    </div>

                    <form id="addToCartForm" novalidate action="/" class="si-form" method="POST"
                          @submit.prevent="addToCart(
							{
								<?= $product->id ?>:{
                                    img: '<?= substr(Json::encode($product->bucket()->getFileUrl($product->image->path)), 1, -1) ?>',
                                    title: '<?= substr(Json::encode($product->titleLang), 1, -1) ?>',
                                    header: '<?= substr(Json::encode($product->descrLang), 1, -1) ?>',
                                    price: <?= round($discount->hasDiscount() ? $discount->calcPrice($product->priceInCurrency) : $product->priceInCurrency) ?>,
								}
							}, $event
						)"
                    >

                        <input type="hidden" name="id" value="<?= $product->id ?>">
                        <input type="hidden" name="" value="getProductOptions('<?= $product->id ?>')">

                        <div class="si-form-row">
                            <div class="form-count-row">
                                <div class="input-header form-count-title">Кількість:</div>
                                <qtcounter/>
                            </div>
                        </div>

                        <div class="si-form-row" v-if="optionsData">
                            <div class="input-wp input-select-wp">
                                <select v-model="pageSlug" name="options" class="ss-select" required id="ssselect"></select>
                            </div>
                        </div>

                        <button class="btn btn-row ic-cart-add" v-if="!itemInCart('<?= $product->id ?>')" type="submit">Додати в кошик</button>
                        <div class="btn btn-row add-to-cart-btn add-to-cart-btn-disable" v-else="">Товар вже в кошику</div>

                        <div class="form_tnx">
                            <div class="form_tnx_header">Товар добавлено в корзину</div>
                            <div class="form_tnx_subheader">
                                Відкрийте кошик, щоб оформити замовлення чи видалити товар із замовлення
                            </div>
                            <button type="button" @click="modal('cart')" class="btn sm btn-white form_tnx_btn">Відкрити кошик</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</article>
<article class="si-tabs-article">
    <div class="container si-tabs-contaioner">
        <div class="si-tab-header-pc-wp">
            <?php if ($product->materialsLang) { ?>
                <button @click="siTab=1" :class="{active:siTab==1}" class="btn sm btn-white si-tab-header si-tab-header-pc" type="button">Опис та розміри</button>
            <?php } ?>
            <?php if ($product->documentations) { ?>
                <button @click="siTab=2" :class="{active:siTab==2}" class="btn sm btn-white si-tab-header si-tab-header-pc" type="button">Інструкції</button>
            <?php } ?>
            <?php if ($product->packageLang) { ?>
                <button @click="siTab=3" :class="{active:siTab==3}" class="btn sm btn-white si-tab-header si-tab-header-pc" type="button">Комплект</button>
            <?php } ?>
            <?php if ($product->infoLang) { ?>
                <button @click="siTab=4" :class="{active:siTab==4}" class="btn sm btn-white si-tab-header si-tab-header-pc" type="button">Інше</button>
            <?php } ?>
        </div>
        <div class="si-tabs">

            <?php if ($product->materialsLang) { ?>
                <div class="si-tab" :class="{active:siTab==1}">
                    <button type="button" @click="siTab=1" class="si-tab-btn si-tab-header ic-arrow-down">Опис та розміри</button>
                    <div class="content si-tab-container">
                        <?= $product->materialsLang ?>
                    </div>
                </div>
            <?php } ?>

            <?php if ($product->documentations) { ?>
                <div class="si-tab" :class="{active:siTab==2}">
                    <button type="button" @click="siTab=2" class="si-tab-btn si-tab-header ic-arrow-down">Інструкції</button>
                    <div class="content si-tab-container">

                        <div class="doc-table">
                            <?php foreach ($product->documentations as $documentation) { ?>
                                <div class="doc-row">
                                    <div class="doc-title"><?= Html::encode($documentation->titleLang) ?></div>
                                    <div class="doc-link-td"><a href="<?= $documentation->url ?>" target="blank">Переглянути документацію</a></div>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>
            <?php } ?>

            <?php if ($product->packageLang) { ?>
                <div class="si-tab" :class="{active:siTab==3}">
                    <button type="button" @click="siTab=3" class="si-tab-btn si-tab-header ic-arrow-down">Комплект</button>
                    <div class="content si-tab-container">
                        <?= $product->packageLang ?>
                    </div>
                </div>
            <?php } ?>

            <?php if ($product->infoLang) { ?>
                <div class="si-tab" :class="{active:siTab==4}">
                    <button type="button" @click="siTab=4" class="si-tab-btn si-tab-header ic-arrow-down">Інше</button>
                    <div class="content si-tab-container">
                        <?= $product->infoLang ?>
                    </div>
                </div>
            <?php } ?>

        </div><!-- si-tabs -->
    </div>
</article>

<?= \frontend\widgets\CarouselWidget::widget(['title' => 'Популярні товари']) ?>