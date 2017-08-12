<template>
	<h1 v-text="text"></h1>
</template>
<script>
import { mapActions,mapState } from 'vuex';
export default{
	data(){
		return {
			text: this.getText()
		}
	},
	computed:{
		...mapState({
			loading: state => state.misc.loading
		}),
	},
	mounted(){
		this.isLoading(false);
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		}),
		getText: function () {
			return 'Hi, ' + this.$route.path;
		}
	}
}
</script>
