<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;

$popularQueries = Yii::$app->contentSettings->getSearchQueries();

?>
<v-modal ref="search" name="search">
    <div class="search-container" id="search-container">
        <preloader></preloader>
        <form class="search-form" action="<?= Url::to(['catalog/search']) ?>" method="get" @submit="$root.initSearch();fbp('Search')">
            <div class="input-wp search-form-input-wp">
                <input type="text" v-model="searchString" name="query" class="search-form-input" required>
                <label>Введіть артикуль чи назву для пошуку...</label>
                <button class="btn ic-close search-reset-btn" type="reset"></button>
            </div>
            <button class="btn btn-row" type="submit">Пошук</button>
        </form>
        <?php if ($popularQueries) { ?>
            <div class="search-queries-wp">
                <h3 class="search-queries-header">Популярні запити</h3>
                <?php foreach ($popularQueries as $query) { ?>
                    <div class="search-query-wp">
                        <span class="search-query-icon ic-magnifier"></span>
                        <a @click="$root.initSearch()" href="<?= Url::to(['/catalog/search', 'query' => $query['query']]) ?>" class="search-query"><?= Html::encode($query['query']) ?></a>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</v-modal>

<v-modal ref="booking" name="booking">
    <form class="booking-form" action="/" method="get" id="booking-form" @submit.prevent="ajaxForm('booking',$event);fbp('Purchase')" v-if="cartHasItems()">
        <div class="container-header">
            Оформлення замовлення
        </div>

        <div class="input-wp">
            <input type="text" name="fio" required value="алина карякина">
            <label>Ім'я та прізвище</label>
        </div>
        <div class="input-wp">
            <input type="text" name="phone" class="phonenumber" @keyup="getUserBonus($event)" required value1="+380939104877">
            <label>Номер телефону</label>
        </div>
        <div class="input-wp">
            <input type="text" name="city" required value="киев">
            <label>Місто</label>
        </div>
        <div class="input-wp">
            <input type="text" name="number" required value="23">
            <label>Номер відділення</label>
        </div>
        <div class="input-wp">
            <textarea name="msg">Комментарий к заказу</textarea>
            <label>Коментар до замовлення</label>
        </div>

        <div class="skidka-box" v-if="getBonus()>0">
            <div class="skidka-header">У вас на рахунку</div>
            <div class="item-card-price cart-total-price skidka-percent">{{getBonus() | price}}<span>&#8372;</span></div>
            <div class="skidka-sub-header">бонусних гривень</div>
        </div>

        <div class="container-header">
            Спосіб оплати
        </div>

        <div class="input-wp">
            <input v-model="paymentType" type="radio" name="paymenttype" value="card" required id="payment_type_card" checked>
            <label for="payment_type_card" class="label-btn ic-p-card">Онлайн оплата (VISA/MasterCard)</label>
        </div>

        <div class="input-wp">
            <input v-model="paymentType" type="radio" name="paymenttype" value="cash" required id="payment_type_cash">
            <label for="payment_type_cash" class="label-btn ic-p-cash">Накладний платіж</label>
        </div>

        <div class="input-wp use-skidka-input" v-if="getBonus()>0">
            <input type="checkbox" name="bonus" v-model="useBonus" id="payment_bonuses">
            <label for="payment_bonuses">Використати бонуси <b>&nbsp;({{ bonusToEat() | price}}&#8372;)</b></label>
        </div>

        <br>

        <div class="cart-price-wp sm" v-if="useBonus&&getBonus()>0">
            <div class="cart-price-text">Загальна вартість</div>
            <div class="item-card-price cart-total-price">{{totalCartPrice() | price}}<span>&#8372;</span></div>
        </div>
        <div class="cart-price-wp sm" v-if="useBonus&&getBonus()>0">
            <div class="cart-price-text">Бонуси</div>
            <div class="item-card-price cart-total-price">-{{bonusToEat() | price}}<span>&#8372;</span></div>
        </div>
        <div class="cart-price-wp">
            <div class="cart-price-text">До оплати</div>
            <div class="item-card-price cart-total-price">{{totalCartPriceToPayment() | price}}<span>&#8372;</span></div>
        </div>

        <button class="btn btn-row" type="submit">Замовити</button>
    </form>
    <div v-else="" class="empty-cart-wp">
        <div class="empty-cart-icon ic-cart"></div>
        <div class="empty-cart-text">Ваш кошик пустий...<br>Перейдіть у каталог, щоб продовжити шопінг</div>
        <button class="btn" type="button">В каталог</button>
    </div>
</v-modal>

<v-modal ref="tnx" name="tnx">
    <div class="modal-tnx-container">
        <div class="modal-tnx-icon ic-cart"></div>
        <div class="modal-tnx-header">Дякуємо за замовлення!</div>
        <div class="modal-tnx-subheader">Наші менеджери зв'яжуться<br>з вами найближчим часом</div>
        <a href="<?= Url::to(['/catalog/index']) ?>" class="btn btn-white sm">В каталог</a>
    </div>
</v-modal>

<v-modal ref="cart" name="cart">
    <div class="container-header">Мій кошик</div>
    <v-cart ref="cartItems" />
</v-modal>