<template>
	<div class="page-content-container">
		<div class="page-content-row">

            <div class="page-sidebar">
                <side-nav :links="links"></side-nav>
            </div>

            <div class="page-content-col">
            	<router-view v-bind:school="school" v-if="school"></router-view>
            </div>
		</div>
	</div>
</template>
<script>
import axios from '../helpers/http';
import { mapActions,mapState } from 'vuex';
import $style from '../helpers/style.js';
let style = new $style();

export default{
	components: {
		'side-nav': require('./SideNav'),
	},
	data(){
		return {
			school: false,
			links: [
				{path: '', text: "About", icon: "icon-home"},
				{path: 'users', text: "Users", icon: "icon-users"},
				{path: 'edit', text: 'Edit', icon: 'icon-settings'}
			]
		};
	},
	computed:{
		...mapState({
			loading: state => state.misc.loading
		}),
	},
	mounted(){
		this.fetchData();
		
	},
	destroyed(){
		
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		}),
		fetchData(){
			this.isLoading(true);
			axios.get('schools/' + this.$route.params.slug)
				.then( (response)=>{
					this.school = response.data;
					setTitle(this.$root, response.data.name , response.data.name);
				} )
				.catch(errors=>{});
			this.isLoading(false);
		},
	},
	beforeRouteEnter(to, from, next){
		next(vm=>{
			vm.fetchData();
		});
	}
}
</script>
