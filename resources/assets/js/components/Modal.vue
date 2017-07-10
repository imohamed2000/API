<template>
	<div class="modal fade in" v-if="props.show" style="display:block">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<slot name="modal-title"></slot>
				</div>
				<div class="modal-body">
					<slot name="modal-body"></slot>
				</div>
				<div class="modal-footer">
					<slot name="modal-footer"></slot>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default{
	props: ['props'],
}
</script>
