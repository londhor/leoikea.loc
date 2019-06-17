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

		<div
			v-else=""
			class="empty-cart-wp"
		>	
			<div class="empty-cart-icon ic-cart"></div>
			<div class="empty-cart-text">Ваша корзина пуста...<br>Перейдите в каталог, чтобы продолжить шоппинг</div>
			<button class="btn" type="button">В каталог</button>	
		</div>

		<div class="cart-footer" v-if="cartHasItems()">
			<div class="cart-price-wp">
				<div class="cart-price-text">Общая стоимость</div>
				<div class="item-card-price cart-total-price">{{totalCartPrice() | price}}<span>&#8372;</span></div>
			</div>
			<button class="btn btn-row" type="button">Заказать</button>
		</div>

	</div>
</template>