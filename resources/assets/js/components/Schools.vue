<template>
	<datatable></datatable>
</template>
<script>
import {mapActions} from 'vuex';
import datatable from './datatable';

export default{
	components:{
		datatable: datatable
	},
	created(){
		this.fetchData();
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		}),
		fetchData(){
			this.isLoading(false);
		},
		watch:{
			'$route': 'fetchData'
		}
	},
}
</script>
