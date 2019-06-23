<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;

$popularQueries = [
    'Ліжко',
    'Стіл',
    'Шафа',
];

?>
<v-modal ref="search" name="search">
    <div class="search-container">
        <form class="search-form" action="<?= Url::to(['catalog/search']) ?>" method="get">
            <div class="input-wp search-form-input-wp">
                <input type="text" v-model="searchString" name="query" class="search-form-input" required autofocus>
                <label>Введіть артикуль чи назву для пошуку...</label>
                <button class="btn ic-close search-reset-btn" type="reset"></button>
            </div>
            <button class="btn btn-row">Пошук</button>
        </form>
        <div class="search-queries-wp">
            <h3 class="search-queries-header">Популярні запити</h3>
            <?php foreach ($popularQueries as $query) { ?>
                <div class="search-query-wp">
                    <span class="search-query-icon ic-magnifier"></span>
                    <a href="<?= Url::to(['/catalog/search', 'query' => $query]) ?>" class="search-query"><?= Html::encode($query) ?></a>
                </div>
            <?php } ?>
        </div>
    </div>
</v-modal>

<v-modal ref="booking" name="booking">
    <form class="booking-form" action="/" method="get" id="booking-form" @submit.prevent="ajaxForm('booking',$event)">
        <div class="container-header">
            Оформлення замовлення
        </div>
        <input type="hidden" name="cart" :value="getCartJson()">
        <div class="input-wp">
            <input type="text" name="fio" required>
            <label>Ім'я та прізвище</label>
        </div>
        <div class="input-wp">
            <input type="text" name="phone" required>
            <label>Номер телефону</label>
        </div>
        <div class="input-wp">
            <input type="text" name="city" required>
            <label>Місто</label>
        </div>
        <div class="input-wp">
            <input type="text" name="number" required>
            <label>Номер відділення</label>
        </div>
        <div class="input-wp">
            <textarea name="msg"></textarea>
            <label>Коментар до замовлення</label>
        </div>
        <button class="btn btn-row">Замовити</button>
    </form>
</v-modal>

<v-modal ref="tnx" name="tnx">
    <div class="modal-tnx-container">
        <div class="modal-tnx-icon ic-cart"></div>
        <div class="modal-tnx-header">Дякуємо за замовлення!</div>
        <div class="modal-tnx-subheader">Наші менеджери зв'яжуться<br>з вами найближчим часом</div>
        <a href="<?= Url::to(['/catalog/index']) ?>" class="btn sm">В каталог</a>
    </div>
</v-modal>

<v-modal ref="cart" name="cart">
    <div class="container-header">Мій кошик</div>
    <v-cart ref="cartItems" />
</v-modal>