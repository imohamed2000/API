<template>
	<portlet :props="{title: $t('New Year'), class:'solid grey-cararra', icon:'icon-plus'}">
		<form slot="body" @submit.prevent="onSubmit" ref="form" @keydown=" errors.clear($event.target.name) ">
			<div class="form-group" :class=" errors.has('name') ? 'has-error' : '' ">
				<label for="year-name" v-text="$t('Name')"></label>
				<input type="text" name="name" class="form-control" id="year-name" :placeholder="$t('Name')">
				<p class="help-block" v-text=" errors.get('name') "></p>
			</div>
			<div class="row" slot="footer">
				<div class="col-md-12">
					<button class="pull-right btn green mt-ladda-btn ladda-button"
					 data-style="zoom-in" 
					 type="submit" ref="submit" v-text="$t('Submit')"></button>
				</div>
			</div>
		</form>
	</portlet>
</template>
<script>

import { mapActions } from 'vuex';
import axios from '../helpers/http';
import Errors from '../helpers/errors';
import ladda from 'ladda';
import toastr from '../helpers/toastr.js';
//import $style from '../helpers/style.js';
//let style = new $style();
//
import portlet from './Portlet';

export default{
	props: ['school'],
	components:{
		portlet
	},
	data(){
		return {
			errors: new Errors(),
		};
	},
	computed: {

	},
	mounted(){
		
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		}),
		onSubmit: function(){
			// Starting loading animation
			let animation = ladda.create(this.$refs.submit );
			animation.start();
			
			// Getting form data
			let formData = new FormData( this.$refs.form );
			let url = `school/${this.school.id}/years`;

			// sending ajax request
			axios.post(url, formData)
				.then((response)=>{
					this.$emit('created');
					this.$refs.form.reset();
				})
					.catch((errors)=>{
						this.errors.record(errors.response.data);
					})
						.then(()=>{
							animation.stop();
						});
		}
	},
	beforeRouteEnter(to, from, next){
		next(vm=>{
			// vm.fetchData();
		});
	}
}
</script>
