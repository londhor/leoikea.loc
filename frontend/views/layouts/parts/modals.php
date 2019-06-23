<?php

/* @var $this yii\web\View */

?>
<template id="v-modal">
    <div class="modal" :class="[{active:show},{leave:leave_class}]" :id="'modal_'+class_name">
        <button class="modal-close-bg" @click="close()"></button>
        <div class="card modal_scroll">
            <div class="modal_wp">
                <slot></slot>
            </div>
            <div class="modal-footer">
                <button class="modal_close ic-close" @click="close()"></button>
            </div>
        </div>
    </div>
</template>

<template id="v-cart">
    <div id="#cart" class="cart-container">
        <div class="cart-items-wp" v-if="cartHasItems()">
            <!-- cart-item -->
            <v-cart-item
                v-for="(item, key, i) in cart"
                :key="key"
                :item="item"
                :itemid="key"
                v-if="item"
                @removeitemfromcart="removeitemfromcart"
                @update-count-in-cart="updateCountInCart"
            />
            <!-- #cart-item -->
        </div>

        <div v-else="" class="empty-cart-wp">
            <div class="empty-cart-icon ic-cart"></div>
            <div class="empty-cart-text">Ваш кошик пустий...<br>Перейдіть у каталог, щоб продовжити шопінг</div>
            <button class="btn" type="button">В каталог</button>
        </div>

        <div class="cart-footer" v-if="cartHasItems()">
            <div class="cart-price-wp">
                <div class="cart-price-text">Загальна вартість</div>
                <div class="item-card-price cart-total-price">{{totalCartPrice() | price}}<span>&#8372;</span></div>
            </div>
            <button @click="openBookingModal()" class="btn btn-row" type="button">Замовити</button>
        </div>
    </div>
</template>

<template id="v-cart-item">
    <div class="cart-item">
        <div class="cart-item-img-wp" v-show="item.img">
            <img :src="item.img">
        </div>
        <div class="cart-item-content">
            <div class="cart-item-title" v-show="item.title">{{item.title}}</div>
            <div class="cart-item-header" v-show="item.header">{{item.header}}</div>
            <div class="cart-item-price-wp" v-show="item.price">
                <div class="item-card-price cart-item-price">
                    {{item.price}}<span>&#8372;</span>
                    <span class="per-item">за шт.</span>
                </div>
            </div>
            <div class="cart-item-options-wp" v-if="item.options">
                <div
                    v-for="(option, oi, okey) in item.options"
                    :key="okey"
                    class="cart-item-option">
                    {{option.name}}:
                    <span>{{option.value}}</span>
                </div>
            </div>
            <qtcounter @update-count-in-cart="updateCountInCart" class="cart-item-count" :count="item.count" />
        </div>
        <div class="cart-item-footer">
            <button class="ic-bin cart-item-delete" type="button"
                    @click="removeitemfromcart()"
            ></button>
            <div class="cart-item-total-price-wp">
                <div class="cart-item-total-price-text">Загальна вартість</div>
                <div class="item-card-price cart-item-price">{{itemTotalPrice() | price }}<span>&#8372;</span></div>
            </div>
        </div>
    </div>
</template>

<template id="qtcounter">
    <div class="input-count-box">
        <button @click="down()" type="button" class="form-count-btn ic-m-minus minus"></button>
        <div class="form-count-wp" data-text="шт.">
            <input type="text" name="qt" v-model="qt" class="form-count" required>
        </div>
        <button @click="up()" type="button" class="form-count-btn ic-m-plus plus"></button>
    </div>
</template>