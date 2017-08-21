<template>
	<div>
		<router-view v-bind:user="user"></router-view>
	</div>
</template>
<script>
import { mapActions, mapState } from 'vuex';
import axios from '../helpers/http';
// import Errors from '../helpers/errors';
// import ladda from 'ladda';
// import toastr from '../helpers/toastr.js';
// import $style from '../helpers/style.js';
// let style = new $style();

export default{
	data(){
		return {
			user: false,
			links: []
		}
	},
	computed: {
		...mapState({
			loading: state=> state.misc.loading
		}),
	},
	mounted(){
		this.isLoading(true);
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		}),
		fetchData(){
			this.isLoading(true);
			this.user = false;
			let ajaxUrl = `school/${this.$parent.school.id}/users/${this.$route.params.userID}`;
			// Get user
			axios.get(ajaxUrl)
					.then( (response) => {
						// set this user to retreived data
						this.user = response.data;
						// Set Page Title
						setTitle(this, response.data.name , response.data.name);
						//Change navigation links
						this.computeLinks();
						this.$parent.setLinks(this.links);
					})
						.catch(errors => {

						}).then(()=>{
							this.isLoading( false );
						});
				
		},
		computeLinks(){
			let base = `users/${this.user.id}`;
			let links = [
					{path: '', text: 'School Home', icon: 'icon-home'},
					{path: base, text: 'User Profile', icon: 'icon-user', quick: [
						{path: `${base}/edit`, text: 'Settings', icon: 'icon-settings'},
						{path: `${base}/enroll`, text: 'Enrollment', icon: 'icon-graduation'},
					]},
					{path: `${base}/exams`, text: 'Exam Performance', icon: 'icon-book-open'},
					{path: `${base}/attendance`, text: 'Attendance Status', icon: 'icon-calendar'},
					{path: `${base}/rank`, text: 'Class Ranking', icon: 'icon-graph'},
					{path: `${base}/fees`, text: 'Fee status', icon: 'icon-wallet'},
				]

			this.links = links;
		},
	},
	beforeRouteEnter(to, from, next){
		next(vm=>{
			vm.fetchData();
		});
	}
}
</script>
