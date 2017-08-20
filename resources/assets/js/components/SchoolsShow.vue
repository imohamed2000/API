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
				{path: '', text: "About", icon: "icon-home", quick: [
					{path: 'edit', text: 'Edit', icon: 'icon-note'},
				]},
				{path: 'users', text: "Users", icon: "icon-people", quick: [
					{path: 'users/trash', text: "Deleted users", icon: 'icon-trash'}
				]},
				{path: 'grades', text: 'Grades', icon: 'icon-graduation'},
				{path: 'roles', text: "Roles", icon: "icon-organization"},
			]
		};
	},
	computed:{
		...mapState({
			loading: state => state.misc.loading
		}),
	},
	mounted(){
		
	},
	destroyed(){
		
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		}),
		fetchData(){
			this.isLoading(true);
			this.school = false;
			axios.get('schools/' + this.$route.params.slug)
				.then( (response)=>{
					setTitle(this.$root, response.data.name , response.data.name);
					this.school = response.data;
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
