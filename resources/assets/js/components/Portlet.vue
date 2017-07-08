<template>
	<div :class="props.class">

		<div class="portlet-title">
            <div class="caption font-dark" v-if="props.title">
                <i :class="props.icon + ' ' + 'font-dark'"></i>
                <span class="caption-subject bold uppercase" v-text="props.title"></span>
            </div>
            <div class="tools"><slot name="tools"></slot></div>
        </div>
		
		<div class="portlet-body">
			<slot name="body"></slot>
		</div>

		<div class="portlet-footer">
			<slot name="footer"></slot>
		</div>
	</div>

</template>
<script>
export default{
	props: ['props'],
}
</script>
