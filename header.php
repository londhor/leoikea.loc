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
        <a href='/' class="header-logo">
            <img src="../img/logo.svg">
        </a>
        <ul class="header-menu">
            <li>
                <a href="#" class="ic-arrow">Каталог Ikea</a>
                <ul class="sub-menu">
                    <li>
                        <a href="#" class="ic-cart">Submenu item</a>
                        <ul class="sub-menu">
                            <li><a href="#">Sub menu</a></li>
                            <li><a href="#">Sub menu1</a></li>
                            <li><a href="#">Sub menu2</a></li>
                            <li><a href="#">Sub menu3</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="ic-cart">Lorem ipsum dolor.</a>
                        <ul class="sub-menu">
                            <li><a href="#">Sub menu</a></li>
                            <li><a href="#">Sub menu11</a></li>
                            <li><a href="#">Sub menu12</a></li>
                            <li><a href="#">Sub menu13</a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="ic-cart">Lorem ipsum dolor.</a></li>
                    <li><a href="#" class="ic-cart">Диваны и кресла</a></li>
                    <li><a href="#" class="ic-cart">Стеллажи и хранение</a></li>
                    <li><a href="#" class="ic-cart">Столы, столы, стулья и скамейки</a></li>
                    <li><a href="#" class="ic-cart">Текстиль и ковры</a></li>
                    <li><a href="#" class="ic-cart">освещение</a></li>
                    <li><a href="#" class="ic-cart">Украшения и растения</a></li>
                    <li><a href="#" class="ic-cart">Наука и работа</a></li>
                    <li><a href="#" class="ic-cart">Мебель для детей и подростков</a></li>
                    <li><a href="#" class="ic-cart">Шкафы и шкафы для хранения одежды</a></li>
                    <li><a href="#" class="ic-cart">Кровати и матрасы</a></li>
                    <li><a href="#" class="ic-cart">Мебель и аксессуары для ванных комнат</a></li>
                    <li><a href="#" class="ic-cart">Организация дома и уборка</a></li>
                    <li><a href="#" class="ic-cart">Кухонная мебель и бытовая техника</a></li>
                    <li><a href="#" class="ic-cart">Кулинарные аксессуары</a></li>
                    <li><a href="#" class="ic-cart">Еда и подача блюд</a></li>
                    <li><a href="#" class="ic-cart">Бытовая электроника</a></li>
                    <li><a href="#" class="ic-cart">Садовая мебель</a></li>
                </ul>
            </li>
            <li><a href="#">Контакты</a></li>
        </ul>
        <div class="header-buttons">
            <button class="btn icon round header-button ic-phone-call"></button>
            <button @click="modal('search')" class="btn icon round header-button ic-magnifier"></button>
            <button @click="modal('cart')" class="btn icon round header-button ic-cart">
                <span class="cart-point active"></span>
            </button>
            <button @click="mm=true" class="btn icon round header-button ic-burger"></button>
        </div>
    </div>
</header>

<div id="mm" class="mobile-menu active" :class="{active:mm}">
    
</div>

<main class="site_main" id="site_main">