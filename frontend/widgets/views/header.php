<?php

/** @var $this \yii\web\View */
/** @var $categories \common\models\shop\Category[] */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<header id="header" :class="{ min:pageScroll >= 60 }">
    <div class="container header-container">
        <a href="<?= Url::to(['/site/index']) ?>" class="header-logo ic-logo-1"></a>
        <ul class="header-menu">
            <a href="<?= Url::to(['/catalog/index']) ?>" class="ic-arrow-down" :class="{active: menu}" @mouseleave="menu=false" @mouseover="menu=true">Каталог Ikea</a>
            <a href="<?= Url::to(['/site/contacts']) ?>">Контакти</a>
        </ul>
        <div class="header-buttons">
            <button class="btn icon round header-button ic-phone-call"></button>
            <button @click="modal('search')" class="btn icon round header-button ic-magnifier"></button>
            <button @click="modal('cart')" class="btn icon round header-button ic-cart">
                <span class="cart-point" :class="{active: cartHaveItems()}"></span>
            </button>
            <button @click="mobileMenu=!mobileMenu" class="btn icon round header-button openMenuBtn"
                    :class="[{'ic-close':mobileMenu}, 'ic-burger']"
            ></button>
        </div>
    </div>
</header>

<div id="menu" class="main-menu" :class="{active:menu}">
    <div class="card menu-container" @mouseleave="menu=false" @mouseenter="menu=true">
        <div class="menu-cats">
            <?php foreach ($categories as $category) { ?>
                <a href="<?= Url::to($category->slug ? ['/catalog/category', 'path' => $category->slug] : '#') ?>"
                   class="menu-cat ic-cart" @mouseover="menuSubCat=<?= $category->id ?>">
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

<div class="mobile-menu" :class="{active: mobileMenu}">
    <div class="mm-container">
        <div class="container-header mm-menu-header">Каталог Ikea</div>
        <ul class="mm-menu">
            <?php $index = 1; ?>
            <?php foreach ($categories as $category) { ?>
                <li class="ic-arrow-down">
                    <a class="ic-category-<?= $index++ ?>" href="<?= Url::to($category->slug ? ['/catalog/category', 'path' => $category->slug] : '#') ?>"><?= Html::encode($category->titleLang) ?></a>
                    <?php if ($category->subCategories) { ?>
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
