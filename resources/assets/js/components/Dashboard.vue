<template>
	<h1><a href="#" @click.prevent="logout">Log Out</a></h1>
</template>
<script>
	import Cookie from 'js-cookie';
	import axios from 'axios';

	export default{
		methods:{
			logout: function(){
				axios.post('api/v1/logout')
						.then(response => {
							Cookie.remove('isGuest');
							this.$store.dispatch('toGuest');
						})
						.catch( errors => {} );
			}
		},
		mounted(){
			document.title = this.$t("Odigita LMS ") + " | " + this.$t("Dashboard") ;
		},
		destroyed(){

		}
	}
</script>