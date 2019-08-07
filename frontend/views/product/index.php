<?php

/* @var $this \yii\web\View */
/* @var $product null|\common\models\shop\Product */
/* @var $priceSettings \frontend\components\PriceSettings */
/* @var $isMobile bool */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
 
$formatter = Yii::$app->formatter;
$priceSettings = Yii::$app->priceSettings;

?>
<article class="item-article">
    <div class="container item-container">
        <div class="breadcrubs-wp">
            <div class="breadcrubs">
                <a href="<?= Url::to(['/site/index']) ?>" class="ic-arrow-right breadcrubs-element"><?= Yii::t('app', 'Головна') ?></a>
                <a href="<?= Url::to(['/catalog/index']) ?>" class="ic-arrow-right breadcrubs-element"><?= Yii::t('app', 'Каталог') ?></a>
                <?php if ($product->category->parentCategory !== null) { ?>
                    <a href="<?= Url::to(['/catalog/category', 'path' => $product->category->parentCategory->slug]) ?>" class="ic-arrow-right breadcrubs-element"><?= $product->category->parentCategory->titleLang ?></a>
                <?php } ?>
                <a href="<?= Url::to(['/catalog/category', 'path' => $product->category->slug]) ?>" class="ic-arrow-right breadcrubs-element"><?= $product->category->titleLang ?></a>
                <a href="<?= Url::to(['/product/index', 'key' => $product->id]) ?>" class="ic-arrow-right breadcrubs-element breadcrubs-element-current"><?= $product->titleLang ?></a>
            </div>
        </div>

        <div class="single-item-content-container">
            <?php $images = $product->images ?>
            <div class="si-slider-container">
                <div class="swiper-container si-slider">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <?php if ($images) { ?>
                            <?php foreach ($images as $image) { ?>
                                <div class="swiper-slide card coub si-slide">
                                    <img src="<?= $product->bucket()->getFileUrl($image->path) ?>" alt="<?= Html::encode($product->productName) ?>">
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="swiper-slide card coub si-slide">
                                <div class="item-card-img-bg"><?= Yii::t('app', 'Зображення відсутнє...') ?></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php if (count($images) > 1) { ?>
                    <div class="swiper-container si-thumbs">
                        <div class="swiper-wrapper">
                            <?php foreach ($images as $image) { ?>
                                <div class="swiper-slide card coub si-thumb">
                                    <img src="<?= $product->bucket()->getFileUrl($image->path) ?>" alt="<?= Html::encode($product->productName) ?>">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="si-main-content-wp">
                <div class="si-main-content-container">
                    <div class="si-main-content">
                        <?php if ($product->article): ?>
                        <div class="si-article"><span><?= Yii::t('app/product', 'Артикул') ?></span><?= Html::encode($product->article) ?></div>
                        <?php endif ?>
                        <h1 class="si-title"><?= Html::encode($product->titleLang) ?></h1>
                        <h2 class="si-subheader"><?= Html::encode($product->descrLang) ?></h2>
                        <div class="item-card-price-wp si-item-card-price-wp">
                            <div class="item-card-price"><?= $formatter->asDecimal($priceSettings->calcDiscount($product->price,$product->category->id)) ?><span>&#8372;</span></div>
                            <?php if ($priceSettings->hasDiscount()) { ?>
                                <div class="item-card-price item-card-price-sale"><?= $formatter->asDecimal($priceSettings->calcPrice($product->price,$product->category->id)) ?><span>&#8372;</span></div>
                            <?php } elseif($product->old_price > $product->price) { ?>
                                <div class="item-card-price item-card-price-sale"><?= $formatter->asDecimal($priceSettings->calcPrice($product->old_price,$product->category->id)) ?><span>&#8372;</span></div>
                            <?php } ?>
                        </div>
                    </div>

                    <form id="addToCartForm" novalidate action="/" class="si-form" method="POST"
                          @submit.prevent="addToCart(
							{
								'<?= $product->id ?>':{
                                    img: '<?= substr(Json::encode($product->bucket()->getFileUrl($product->image->path)), 1, -1) ?>',
                                    title: '<?= substr(Json::encode($product->titleLang), 1, -1) ?>',
                                    header: '<?= substr(Json::encode($product->descrLang), 1, -1) ?>',
                                    price: <?= round($priceSettings->calcDiscount($product->price,$product->category->id)) ?>,
								}
							}, $event
						);fbp('AddToCart')"
                    >

                        <input type="hidden" name="id" value="<?= $product->id ?>">
                        <input type="hidden" name="" value="getProductOptions('<?= $product->id ?>')">

                        <div class="si-form-row">
                            <div class="form-count-row">
                                <div class="input-header form-count-title"><?= Yii::t('app/product', 'Кількість:') ?></div>
                                <qtcounter/>
                            </div>
                        </div>

                        <div class="si-form-row" v-if="optionsData">
                            <div class="input-wp input-select-wp">
                                <select v-model="pageSlug" name="options" class="ss-select" required id="ssselect"></select>
                            </div>
                        </div>

                        <button class="btn btn-row ic-cart-add" v-if="!itemInCart('<?= $product->id ?>')" type="submit"><?= Yii::t('app/cart', 'Додати в кошик') ?></button>
                        <div class="btn btn-row add-to-cart-btn add-to-cart-btn-disable" v-else="itemInCart('<?= $product->id ?>')"><?= Yii::t('app/cart', 'Товар вже в кошику') ?></div>

                        <div class="form_tnx">
                            <div class="form_tnx_header"><?= Yii::t('app/cart', 'Товар додано в кошик') ?></div>
                            <div class="form_tnx_subheader">
                                <?= Yii::t('app/cart', 'Відкрийте кошик, щоб оформити чи змінити замовлення') ?>
                            </div>
                            <button type="button" @click="modal('cart')" class="btn sm btn-white form_tnx_btn ic-cart-move"><?= Yii::t('app/cart', 'Відкрити кошик') ?></button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</article>
<?php if ($product->infoLang || $product->documentations || $product->packageLang || $product->materialsLang): ?>
<article class="si-tabs-article">
    <div class="container si-tabs-contaioner">
        <?php if ($product->infoLang || $product->documentations || $product->packageLang || $product->materialsLang): ?>
        <div class="si-tab-header-pc-wp">
            <?php if ($product->infoLang) { ?>
                <button @click="siTab=1" :class="{active:siTab==1}" class="btn sm btn-white si-tab-header si-tab-header-pc" type="button"><?= Yii::t('app/product', 'Опис та розміри') ?></button>
            <?php } ?>
            <?php if ($product->documentations) { ?>
                <button @click="siTab=2" :class="{active:siTab==2}" class="btn sm btn-white si-tab-header si-tab-header-pc" type="button"><?= Yii::t('app/product', 'Інструкції') ?></button>
            <?php } ?>
            <?php if ($packageLang = $product->packageLang) { ?>
                <button @click="siTab=3" :class="{active:siTab==3}" class="btn sm btn-white si-tab-header si-tab-header-pc" type="button"><?= Yii::t('app/product', 'Комплект') ?></button>
            <?php } ?>
            <?php if ($product->materialsLang) { ?>
                <button @click="siTab=4" :class="{active:siTab==4}" class="btn sm btn-white si-tab-header si-tab-header-pc" type="button"><?= Yii::t('app/product', 'Інше') ?></button>
            <?php } ?>
        </div>
        <?php endif; ?>
        <div class="si-tabs">

            <?php if ($product->infoLang) { ?>
                <div class="si-tab" :class="{active:siTab==1}">
                    <button type="button" @click="siTab=1" class="si-tab-btn si-tab-header ic-arrow-down"><?= Yii::t('app/product', 'Опис та розміри') ?></button>
                    <div class="content si-tab-container">
                        <?= str_replace('⠀','<br><br>',$product->infoLang) ?>
                    </div>
                </div>
            <?php } ?>

            <?php if ($product->documentations) { ?>
                <div class="si-tab" :class="{active:siTab==2}">
                    <button type="button" @click="siTab=2" class="si-tab-btn si-tab-header ic-arrow-down"><?= Yii::t('app/product', 'Інструкції') ?></button>
                    <div class="content si-tab-container">

                        <div class="doc-table">
                            <?php foreach ($product->documentations as $documentation) { ?>
                                <div class="doc-row">
                                    <div class="doc-title"><?= Html::encode($documentation->titleLang) ?></div>
                                    <div class="doc-link-td"><a href="<?= $documentation->url ?>" target="blank"><?= Yii::t('app/product', 'Переглянути документацію') ?></a></div>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>
            <?php } ?>

            <?php if ($packageLang) { ?>
                <div class="si-tab" :class="{active:siTab==3}">
                    <button type="button" @click="siTab=3" class="si-tab-btn si-tab-header ic-arrow-down"><?= Yii::t('app/product', 'Комплект') ?></button>
                    <div class="content si-tab-container">
                        <table class="tbl-pkg">
                            <thead>
                            <tr>
                                <th class="tbl-pkg__title"><?= Yii::t('app/product', 'Артикул') ?></th>
                                <th class="tbl-pkg__title"><?= Yii::t('app/product', 'Кількість') ?></th>
                                <th class="tbl-pkg__title"><?= Yii::t('app/product', 'Ширина') ?></th>
                                <th class="tbl-pkg__title"><?= Yii::t('app/product', 'Висота') ?></th>
                                <th class="tbl-pkg__title"><?= Yii::t('app/product', 'Довжина') ?></th>
                                <th class="tbl-pkg__title"><?= Yii::t('app/product', 'Діаметр') ?></th>
                                <th class="tbl-pkg__title"><?= Yii::t('app/product', 'Вага') ?></th>
                            </tr>
                            </thead>
                            <?php $emptyTag = '<span class="tbl-pkg__empty">-</span>' ?>
                            <?php $index = 0; $groupIndex = 0 ?>
                            <?php foreach ($packageLang as $package) { ?>
                                <?php if ($package['articleNumber'] && $package['pkgInfo']) { ?>
                                    <tbody class="tbl-pkg__group" data-group-index="<?= $groupIndex++ ?>">
                                    <?php foreach ($package['pkgInfo'] as $packageInfo) { ?>
                                        <tr class="tbl-pkg__row tbl-pkg__row-<?= $index % 2 ? 'odd' : 'even' ?>" data-index="<?= $index++ ?>">
                                            <td class="tbl-pkg__col"><a class="tbl-pkg__link" target="blank" href="<?= Url::to(['product/index', 'key' => $package['articleNumber']]) ?>"><?= Html::encode($package['articleNumber']) ?></a></td>
                                            <td class="tbl-pkg__col"><?= isset($packageInfo['quantity']) ? Html::encode($packageInfo['quantity']) : $emptyTag ?></td>
                                            <td class="tbl-pkg__col"><?= isset($packageInfo['widthMet']) ? Html::encode($packageInfo['widthMet']) : $emptyTag ?></td>
                                            <td class="tbl-pkg__col"><?= isset($packageInfo['heightMet']) ? Html::encode($packageInfo['heightMet']) : $emptyTag ?></td>
                                            <td class="tbl-pkg__col"><?= isset($packageInfo['lengthMet']) ? Html::encode($packageInfo['lengthMet']) : $emptyTag ?></td>
                                            <td class="tbl-pkg__col"><?= isset($packageInfo['diameterMet']) ? Html::encode($packageInfo['diameterMet']) : $emptyTag ?></td>
                                            <td class="tbl-pkg__col"><?= isset($packageInfo['weightMet']) ? Html::encode($packageInfo['weightMet']) : $emptyTag ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                <?php } ?>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            <?php } ?>

            <?php if ($product->materialsLang) { ?>
                <div class="si-tab" :class="{active:siTab==4}">
                    <button type="button" @click="siTab=4" class="si-tab-btn si-tab-header ic-arrow-down"><?= Yii::t('app/product', 'Інше') ?></button>
                    <div class="content si-tab-container">
                        <?= $product->materialsLang ?>
                    </div>
                </div>
            <?php } ?>

        </div><!-- si-tabs -->
    </div>
</article>

<?php endif; ?>

<?= frontend\widgets\RecommendedProductsWidget::widget([
    'product' => $product,
    'lastItemUrl' => $product->category === null ? ['/catalog/index'] : ['/catalog/category', 'path' => $product->category->slug],
    'lastItemTitle' => $product->category === null ?
        Yii::t('app', 'В каталог') :
        Yii::t('app', 'Переглянути категорію {category}', ['category' => $product->category->titleLang]),
]) ?>