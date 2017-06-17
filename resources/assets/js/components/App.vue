<template>
	<div>
		<guest v-if="isGuest"/>
		<dashboard v-if="!isGuest" />
	</div>
</template>
<script>
	import Guest from './Guest';
	import Dashboard from './Dashboard';
	import { mapState, mapActions } from 'vuex';
	import Cookie from 'js-cookie';

	export default {
		computed:{
			...mapState({
				isGuest: state => state.login.isGuest
			}),
		},
		methods:{
			...mapActions({
				toAuth: 'toAuth'
			})
		},
		mounted(){

		},
		components: {
			'guest': Guest,
			'dashboard': Dashboard
		},
	}
</script>