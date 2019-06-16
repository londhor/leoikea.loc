<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <title>Leoikea</title>

    <?php $color="#0B2EAA";?>
    <meta name=description content="Описание сайта">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="David Devero | londhor | https://londhor.com">
    <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1,maximum-scale=2,minimum-scale=1">
    <meta name="aple-mobile-web-app-capable" content="yes">
    <meta name="aple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="ya-dock" content="<?=$color?>">
    <meta name="ya-title" content="<?=$color?>">
    <link rel="apple-touch-icon" sizes="180x180" href="../img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicons/favicon-16x16.png">
    <link rel="manifest" href="../img/favicons/manifest.json">
    <link rel="mask-icon" href="../img/favicons/safari-pinned-tab.svg" color="<?=$color?>">
    <link rel="shortcut icon" href="../img/favicons/favicon.ico">
    <meta name="msapplication-TileColor" content="<?=$color?>">
    <meta name="msapplication-TileImage" content="../img/favicons/mstile-144x144.png">
    <meta name="msapplication-config" content="../img/favicons/browserconfig.xml">
    <meta name="theme-color" content="<?=$color?>">


    <meta name='viewport' content='initial-scale=1, viewport-fit=cover'>
    <meta name="apple-mobile-web-app-capable" content="yes">

</head>
<body><div id="app">

<header id="header" :class="{ min:pageScroll >= 60 }">
    <div class="container header-container">
        <a href='/' class="header-logo ic-logo-1">
            <!-- <img src="../img/logo.svg"> -->
        </a>
        <ul class="header-menu">
            <a href="#" class="ic-arrow-down" :class="{active: menu}" @mouseover="menu=true">Каталог Ikea</a>
            <a href="../page-contacts.php">Контакты</a>
        </ul>
        <div class="header-buttons">
            <button class="btn icon round header-button ic-phone-call"></button>
            <button @click="modal('search')" class="btn icon round header-button ic-magnifier"></button>
            <button @click="modal('cart')" class="btn icon round header-button ic-cart">
                <span class="cart-point active"></span>
            </button>
            <button @click="menu=!menu" class="btn icon round header-button openMenuBtn"
                :class="[{'ic-close':menu}, 'ic-burger']"
            ></button>
        </div>
    </div>
</header>

<div id="menu" class="main-menu" :class="{active:menu}">
    <div class="card menu-container" @mouseleave="menu=false">
        <div class="menu-cats">
            <a href="#" class="menu-cat ic-cart" @mouseover="menuSubCat=1">Диваны и кресла</a>
            <a href="#" class="menu-cat ic-cart" @mouseover="menuSubCat=3">Стеллажи и хранение</a>
            <a href="#" class="menu-cat ic-cart" @mouseover="menuSubCat=4">Столы, столы, стулья и скамейки</a>
            <a href="#" class="menu-cat ic-cart" @mouseover="menuSubCat=5">Текстиль и ковры</a>
            <a href="#" class="menu-cat ic-cart" @mouseover="menuSubCat=6">освещение</a>
            <a href="#" class="menu-cat ic-cart" @mouseover="menuSubCat=7">Украшения и растения</a>
            <a href="#" class="menu-cat ic-cart" @mouseover="menuSubCat=8">Наука и работа</a>
            <a href="#" class="menu-cat ic-cart" @mouseover="menuSubCat=9">Мебель для детей и подростков</a>
            <a href="#" class="menu-cat ic-cart" @mouseover="menuSubCat=10">Шкафы и шкафы для хранения одежды</a>
            <a href="#" class="menu-cat ic-cart" @mouseover="menuSubCat=11">Кровати и матрасы</a>
            <a href="#" class="menu-cat ic-cart" @mouseover="menuSubCat=12">Мебель и аксессуары для ванных комнат</a>
            <a href="#" class="menu-cat ic-cart" @mouseover="menuSubCat=13">Организация дома и уборка</a>
            <a href="#" class="menu-cat ic-cart" @mouseover="menuSubCat=14">Кухонная мебель и бытовая техника</a>
            <a href="#" class="menu-cat ic-cart" @mouseover="menuSubCat=15">Кулинарные аксессуары</a>
            <a href="#" class="menu-cat ic-cart" @mouseover="menuSubCat=16">Еда и подача блюд</a>
        </div>
        <div class="menu-grid menu-subcats">
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">Столы, столы, стулья и скамейки</a>
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">Текстиль и ковры</a>
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">освещение</a>
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">Украшения и растения</a>
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">Наука и работа</a>
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">Мебель для детей и подростков</a>
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">Шкафы и шкафы для хранения одежды</a>
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">Кровати и матрасы</a>
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">Мебель и аксессуары для ванных комнат</a>
            <a href="#" v-show="menuSubCat==10" class="menu-subcat">Организация дома и уборка</a>
            <a href="#" v-show="menuSubCat==10" class="menu-subcat">Кухонная мебель и бытовая техника</a>
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">Кулинарные аксессуары</a>
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">Еда и подача блюд</a>
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">Столы, столы, стулья и скамейки</a>
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">Текстиль и ковры</a>
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">освещение</a>
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">Украшения и растения</a>
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">Наука и работа</a>
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">Мебель для детей и подростков</a>
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">Шкафы и шкафы для хранения одежды</a>
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">Кровати и матрасы</a>
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">Мебель и аксессуары для ванных комнат</a>
            <a href="#" v-show="menuSubCat==10" class="menu-subcat">Организация дома и уборка</a>
            <a href="#" v-show="menuSubCat==10" class="menu-subcat">Кухонная мебель и бытовая техника</a>
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">Кулинарные аксессуары</a>
            <a href="#" v-show="menuSubCat==1" class="menu-subcat">Еда и подача блюд</a>
        </div>
    </div>
</div>

<main class="site_main" id="site_main">