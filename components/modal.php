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