<template>
	
</template>
<script>
import {mapActions} from 'vuex';
export default{
	methods: {
		...mapActions({
			setPageTitle: 'setPageTitle'
		}),
	},

	mounted(){
		this.setPageTitle(this.$t('All Schools'));
	},

	
}
</script>
