<template>
	<div :class="portlet.class">

		<div class="portlet-title">
            <div class="caption font-dark" v-if="portlet.title">
                <i :class="portlet.icon + ' ' + 'font-dark'"></i>
                <span class="caption-subject bold uppercase" v-text="portlet.title"></span>
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
	mounted(){
	},
	computed: {
		portlet: function(){
			let theClass = this.props.class ? `portlet ${this.props.class}` : 'portlet light bordered';
			let title = this.props.title ? this.props.title : 'Provide title property';
			let icon = this.props.icon ? this.props.icon : 'icon-menu';
			return {
				class : theClass,
				title: title,
				icon: icon
			}
		}
	}
}
</script>
