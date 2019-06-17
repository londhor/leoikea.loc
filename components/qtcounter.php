<template id="qtcounter">
	<div class="input-count-box">
		<button @click="down()" type="button" class="form-count-btn ic-m-minus minus"></button>
		<div class="form-count-wp" data-text="шт.">
			<input type="text" v-model="qt" class="form-count" required>
		</div>
		<button @click="up()" type="button" class="form-count-btn ic-m-plus plus"></button>
	</div>
</template>