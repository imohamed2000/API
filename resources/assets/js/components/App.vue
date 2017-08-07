<template>
	<div>
		<guest v-if="isGuest"/>
		<dashboard v-if="!isGuest" />
	</div>
</template>
<script>
	import axios from 'axios';
	import Guest from './Guest';
	import Dashboard from './Dashboard';
	import { mapState, mapActions } from 'vuex';
	import Cookie from 'js-cookie';
	import $style from '../helpers/style.js';
	
	let style = new $style();

	require('bootstrap');
	export default {
		computed:{
			...mapState({
				isGuest: state => state.login.isGuest
			}),
		},
		methods:{
			...mapActions({
				toAuth: 'toAuth',
				toGuest: 'toGuest',
				setTitle: 'setTitle'
			})
		},
		mounted(){
			style.pushStyle('plugins/ladda/ladda-themeless.min.css');
			// axios.interceptors.response.use(function (response) {
			//     // Do something with response data
			//     return response;
			//   }, function (error) {
			//     // Do something with response error
			//     // Token Expired
			//     if(error.response.status === 401){
			//     	oThis.$store.dispatch('toGuest');
			//     }
			//     return Promise.reject(error);
			//   });
		},
		components: {
			'guest': Guest,
			'dashboard': Dashboard
		},
		destroyed(){
			style.popStyle('plugins/ladda/ladda-themeless.min.css');
		}
	}
</script>
