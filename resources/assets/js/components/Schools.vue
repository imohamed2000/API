<template>
	
</template>
<script>
import {mapActions} from 'vuex';

export default{
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
