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
			style.pushStyle('/plugins/ladda/ladda-themeless.min.css');
		},
		components: {
			'guest': Guest,
			'dashboard': Dashboard
		},
		destroyed(){
			style.popStyle('/plugins/ladda/ladda-themeless.min.css');
		}
	}
</script>
