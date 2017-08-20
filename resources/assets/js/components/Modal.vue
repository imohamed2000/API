<template>
	<div class="modal fade in" tabindex="-1" aria-hidden="true" v-show="props.show" style="display:block">
		<div :class="size">
			<div class="modal-content">
				<div class="modal-header">
					<button @click="props.show = false" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<slot name="modal-title"></slot>
				</div>
				<slot name="modal-content"></slot>
			</div>
		</div>
	</div>
</template>
<script>
export default{
	props: ['props'],
	computed: {
		size: function(){
			let sizes = {
				basic: 'modal-dialog',
				full: 'modal-dialog modal-full',
				large: 'modal-dialog modal-lg',
				small: 'modal-dialog modal-sm'
			};
			return sizes[this.props.size];
		}
	}
}
</script>
