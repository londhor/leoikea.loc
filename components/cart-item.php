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
			<div class="input-count-box cart-item-count">
				<button type="button" class="form-count-btn ic-m-minus minus"></button>
				<div class="form-count-wp" data-text="шт.">
					<input type="text" v-model="item.count" class="form-count" required>
				</div>
				<button type="button" class="form-count-btn ic-m-plus plus"></button>
			</div>
		</div>
		<div class="cart-item-footer">
			<button class="ic-bin cart-item-delete" type="button"
				@click="removeitemfromcart()"
			></button>
			<div class="cart-item-total-price-wp">
				<div class="cart-item-total-price-text">Общая стоимость</div>
				<div class="item-card-price cart-item-price">{{itemTotalPrice() | price }}<span>&#8372;</span></div>
			</div>
		</div>
	</div>
</template>			