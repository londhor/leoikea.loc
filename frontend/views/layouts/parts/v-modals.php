<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;

$popularQueries = Yii::$app->contentSettings->getSearchQueries();

?>
<v-modal ref="search" name="search">
    <div class="search-container" id="search-container">
        <preloader></preloader>
        <form class="search-form activePreloaderHide" action="<?= Url::to(['catalog/search']) ?>" method="get" @submit="$root.initFormPreloader($event,'#modal_search');fbp('Search')">
            <div class="input-wp search-form-input-wp">
                <input type="text" v-model="searchString" name="query" class="search-form-input" required>
                <label><?= Yii::t('app/search', 'Введіть артикуль чи назву для пошуку...') ?></label>
                <button class="btn ic-close search-reset-btn" type="reset"></button>
            </div>
            <button class="btn btn-row activePreloaderHide" type="submit"><?= Yii::t('app/search', 'Пошук') ?></button>

        <?php if ($popularQueries) { ?>
            <div class="search-queries-wp">
                <h3 class="search-queries-header"><?= Yii::t('app/search', 'Популярні запити') ?></h3>
                <?php foreach ($popularQueries as $query) { ?>
                    <div class="search-query-wp">
                        <span class="search-query-icon ic-magnifier"></span>
                        <a @click="$root.initFormPreloader($event,'#modal_search')" href="<?= Url::to(['/catalog/search', 'query' => $query['query']]) ?>" class="search-query"><?= Html::encode($query['query']) ?></a>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>


        </form>
    </div>
</v-modal>

<v-modal ref="booking" name="booking">
    <preloader></preloader>

    <div class="modal-tnx-container modal-tnx-container-booking activePreloaderShow" v-if="paymentType=='card'">
        <div class="modal-tnx-subheader"><?= Yii::t('app/cart', 'Зараз вас буде перенаправлено на платіжну систему для оплати замовлення...') ?></div>
        <a :href="merchant_url" class="btn btn-white sm"><?= Yii::t('app/cart', 'Перейти до оплати') ?></a>
    </div>

    <form class="booking-form activePreloaderHide" action="/" method="get" id="booking-form" @submit.prevent="ajaxForm('booking',$event);$root.initFormPreloader($event,'#modal_booking');fbp('Purchase')" v-if="cartHasItems()">
        <div class="container-header">
            <?= Yii::t('app/cart', 'Оформлення замовлення') ?>
        </div>

        <div class="input-wp">
            <input type="text" name="fio" required>
            <label><?= Yii::t('app/cart', 'Ім\'я та прізвище') ?></label>
        </div>
        <div class="input-wp">
            <input type="text" name="phone" class="phonenumber" @keyup="getUserBonus($event)" required>
            <label><?= Yii::t('app/cart', 'Номер телефону') ?></label>
        </div>
        <div class="input-wp">
            <input type="text" name="city" :required="isRequiredBooking()">
            <label><?= Yii::t('app/cart', 'Місто') ?></label>
        </div>
        <div class="input-wp">
            <input type="text" name="number" :required="isRequiredBooking()">
            <label><?= Yii::t('app/cart', 'Номер відділення') ?></label>
        </div>
        <div class="input-wp">
            <textarea name="msg"></textarea>
            <label><?= Yii::t('app/cart', 'Коментар до замовлення') ?></label>
        </div>

        <div class="skidka-box" v-if="getBonus()>0">
            <div class="skidka-header"><?= Yii::t('app/cart', 'У вас на рахунку') ?></div>
            <div class="item-card-price cart-total-price skidka-percent">{{getBonus() | price}}<span>&#8372;</span></div>
            <div class="skidka-sub-header"><?= Yii::t('app/cart', 'бонусних гривень') ?></div>
        </div>

        <div class="container-header"><?= Yii::t('app/cart', 'Спосіб оплати') ?></div>

        <div class="input-wp">
            <input v-model="paymentType" type="radio" name="paymenttype" value="card" required id="payment_type_card" checked>
            <label for="payment_type_card" class="label-btn ic-p-card"><?= Yii::t('app/cart', 'Онлайн оплата (VISA/MasterCard)') ?></label>
        </div>

        <div class="input-wp">
            <input v-model="paymentType" type="radio" name="paymenttype" value="cash" required id="payment_type_cash">
            <label for="payment_type_cash" class="label-btn ic-p-cash"><?= Yii::t('app/cart', 'Накладний платіж') ?></label>
        </div>

        <div class="input-wp">
            <input v-model="paymentType" type="radio" name="paymenttype" value="magazin" required id="payment_type_magazin">
            <label for="payment_type_magazin" class="label-btn ic-ben-4"><?= Yii::t('app/cart', 'Самовивіз з магазину') ?></label>
        </div>

        <div class="input-wp use-skidka-input" v-if="getBonus()>0">
            <input type="checkbox" name="bonus" v-model="useBonus" id="payment_bonuses">
            <label for="payment_bonuses"><?= Yii::t('app/cart', 'Використати бонуси') ?> <b>&nbsp;({{ bonusToEat() | price}}&#8372;)</b></label>
        </div>

        <br>

        <div class="cart-price-wp sm" v-if="useBonus&&getBonus()>0">
            <div class="cart-price-text"><?= Yii::t('app/cart', 'Загальна вартість') ?></div>
            <div class="item-card-price cart-total-price">{{totalCartPrice() | price}}<span>&#8372;</span></div>
        </div>
        <div class="cart-price-wp sm" v-if="useBonus&&getBonus()>0">
            <div class="cart-price-text"><?= Yii::t('app/cart', 'Бонуси') ?></div>
            <div class="item-card-price cart-total-price">-{{bonusToEat() | price}}<span>&#8372;</span></div>
        </div>
        <div class="cart-price-wp">
            <div class="cart-price-text"><?= Yii::t('app/cart', 'До оплати') ?></div>
            <div class="item-card-price cart-total-price">{{totalCartPriceToPayment() | price}}<span>&#8372;</span></div>
        </div>

        <button class="btn btn-row" type="submit"><?= Yii::t('app/cart', 'Замовити') ?></button>
    </form>
    <div v-else="" class="empty-cart-wp">
        <div class="empty-cart-icon ic-cart"></div>
        <div class="empty-cart-text"><?= Yii::t('app/cart', 'Ваш кошик пустий...<br>Перейдіть у каталог, щоб продовжити шопінг') ?></div>
        <a href="<?= Url::to(['/catalog/index']) ?>" class="btn btn-white sm"><?= Yii::t('app', 'В каталог') ?></a>
    </div>
</v-modal>

<v-modal ref="tnx" name="tnx">
    <div class="modal-tnx-container">
        <div class="modal-tnx-icon ic-cart"></div>
        <div class="modal-tnx-header"><?= Yii::t('app/cart', 'Дякуємо за замовлення!') ?></div>
        <div class="modal-tnx-subheader"><?= Yii::t('app/cart', 'Наші менеджери зв\'яжуться<br>з вами найближчим часом') ?></div>
        <a href="<?= Url::to(['/catalog/index']) ?>" class="btn btn-white sm"><?= Yii::t('app', 'В каталог') ?></a>
    </div>
</v-modal>

<v-modal ref="payment_error" name="payment_error">
    <div class="modal-tnx-container">
        <div class="modal-tnx-icon ic-close-bold"></div>
        <div class="modal-tnx-header"><?= Yii::t('app/cart', 'Помилка оплати...') ?></div>
        <div class="modal-tnx-subheader"><?= Yii::t('app/cart', 'Схоже ви відмінили оплату, або платіж не пройшов. Перевірте наявність коштів на карті чи ліміт оплати в інтернеті. Якщо кошти було списано з карти але ви бачите це вікно — звяжіться з нами.') ?></div>
        <button @click="modalClose('payment_error')" type="button" class="btn btn-white sm"><?= Yii::t('app', 'Закрити') ?></button>
    </div>
</v-modal>

<v-modal ref="cart" name="cart">
    <div class="container-header"><?= Yii::t('app/cart', 'Мій кошик') ?></div>
    <v-cart ref="cartItems" />
</v-modal>