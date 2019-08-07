<?php

/** @var $this \yii\web\View */
/** @var $categories \common\models\shop\Category[] */
/** @var $priceSettings \frontend\components\PriceSettings */
/** @var $languages \frontend\components\multilang\LanguageInterface[] */
/** @var $currentLanguage \frontend\components\multilang\LanguageInterface */
/** @var $phone array|null */

use yii\helpers\Html;
use yii\helpers\Url;

$priceSettings = Yii::$app->priceSettings;
?>
<header id="header" :class="{ min:pageScroll >= 60 }">
    <div class="container header-container">
        <a href="<?= Url::to(['/site/index']) ?>" class="header-logo ic-logo"></a>
        <ul class="header-menu">
            <a href="<?= Url::to(['/catalog/index']) ?>" class="ic-arrow-down" :class="{active: menu}" @mouseleave="menu=false" @mouseover="menu=true"><?= Yii::t('app', 'Каталог Ikea') ?></a>
            <a href="<?= Url::to(['/article/payment-and-delivery']) ?>"><?= Yii::t('app', 'Доставка та оплата') ?></a>
            <a href="<?= Url::to(['/site/index']) ?>#feedback-article"><?= Yii::t('app', 'Відгуки') ?></a>
            <a href="<?= Url::to(['/site/contacts']) ?>"><?= Yii::t('app', 'Контакти') ?></a>
            <a href="<?= Url::to(['/catalog/category/special-deals']) ?>"><?= Yii::t('app', 'Спеціальні пропозиції') ?></a>
        </ul>
        <div class="header-buttons">
            <div class="langs-wp">
                <button class="btn icon round header-button lang-btn lang-btn-current" title="<?= Html::encode($currentLanguage->getNativeName()) ?>" type="button">
                    <img src="<?= $currentLanguage->getFlag() ?>" alt="<?= Html::encode($currentLanguage->getCode()) ?>">
                </button>
                <?php foreach ($languages as $language) {
                    if ($language->isCurrent()) {
                        continue;
                    } ?>
                    <a href="<?= Url::current(['language' => $language->getUrlCode()]) ?>" title="<?= Html::encode($language->getNativeName()) ?>" class="btn icon round header-button lang-btn">
                        <img src="<?= $language->getFlag() ?>" alt="<?= Html::encode($language->getCode()) ?>">
                    </a>
                <?php } ?>
            </div>
            <?php if ($phone !== null) { ?>
                <a @click="fbp('Contact')" href="tel:<?= $phone['phone'] ?>" class="btn icon round header-button ic-phone-call"></a>
            <?php } ?>
            <button @click="modal('search');fbp('view Search')" class="btn icon round header-button ic-magnifier"></button>
            <button @click="modal('cart');fbp('view Cart')" class="btn icon round header-button ic-cart">
                <span class="cart-point" :class="{active: cartHaveItems()}"></span>
            </button>
            <button @click="mobileMenuChangeStatus()" class="btn icon round header-button openMenuBtn"
                    :class="[{'ic-close':mobileMenu, 'ic-burger':!mobileMenu}]"
            ></button>
        </div>
    </div>
</header>

<?php if ($priceSettings->hasDiscountDescription()) { ?>
    <article class="header-sale-article">
        <div class="container header-sale-container">
            <div class="header-sale-text">
                <?= $priceSettings->getDiscountDescription() ?>
            </div>
        </div>
    </article>
<?php } ?>

<div id="menu" class="main-menu" :class="{active:menu}">
    <div class="card menu-container" @mouseleave="menu=false" @mouseenter="menu=true">
        <div class="menu-cats">
            <?php foreach ($categories as $category) { ?>
                <a href="<?= Url::to($category->slug ? ['/catalog/category', 'path' => $category->slug] : '#') ?>"
                   class="menu-cat ic-<?= Html::encode($category->icon) ?>" :class="{active:menuSubCat=='<?= $category->id ?>'}" @mouseover="menuSubCat=<?= $category->id ?>">
                    <?= Html::encode($category->titleLang) ?>
                </a>
            <?php } ?>
        </div>
        <div class="menu-grid menu-subcats">
            <?php foreach ($categories as $parentCategory) { ?>
                <?php foreach ($parentCategory->subCategories as $category) { ?>
                    <a href="<?= Url::to($category->slug ? ['/catalog/category', 'path' => $category->slug] : '#') ?>"
                       class="menu-subcat" v-show="menuSubCat==<?= $category->parent_id ?>">
                        <?= Html::encode($category->titleLang) ?>
                    </a>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>

<div class="mobile-menu" :class="[{'active': mobileMenu}]">
    <div class="mm-container">
        <div class="container-header mm-menu-header"><?= Yii::t('app', 'Меню') ?></div>
        <ul class="mm-menu">
            <li><a href="<?= Url::to(['/site/index']) ?>"><?= Yii::t('app', 'Головна') ?></a></li>
            <li><a href="<?= Url::to(['/article/payment-and-delivery']) ?>"><?= Yii::t('app', 'Доставка та оплата') ?></a></li>
            <li><a href="<?= Url::to(['/site/contacts']) ?>"><?= Yii::t('app', 'Контакти') ?></a></li>
            <li><a href="<?= Url::to(['/catalog/category/special-deals']) ?>"><?= Yii::t('app', 'Спеціальні пропозиції') ?></a></li>

            <div class="container-header mm-menu-header"><?= Yii::t('app', 'Каталог Ikea') ?></div>
            <?php foreach ($categories as $category) { ?>
                <li>
                    <a class="<?= Html::encode($category->icon) ?>" href="<?= Url::to($category->slug ? ['/catalog/category', 'path' => $category->slug] : '#') ?>"><?= Html::encode($category->titleLang) ?></a>
                    <?php if ($category->subCategories) { ?>
                        <mtoggle></mtoggle>
                        <ul class="sub-menu">
                            <?php foreach ($category->subCategories as $subCategory) { ?>
                                <li><a href="<?= Url::to(['/catalog/category', 'path' => $subCategory->slug]) ?>"><?= Html::encode($subCategory->titleLang) ?></a></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </li>
            <?php } ?>

        </ul>
    </div>
</div>