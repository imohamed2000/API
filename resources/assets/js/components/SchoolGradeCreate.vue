<template>
	<portlet :props="{title: $t('New Grade'), class:'solid grey-cararra', icon:'icon-plus'}">
		<form ref="form" slot="body" @submit.prevent="onSubmit" @keydown="errors.clear( $event.target.name )">
			<div class="form-group" :class="errors.has('name') ? 'has-error' : ''">
				<input type="text" name="name" id="name" class="form-control" placeholder="Grade Name">
				<p class="help-block" v-text="errors.get('name')"></p>
			</div>
			<div class="row" slot="footer">
				<div class="col-md-12">
					<button class="pull-right btn green mt-ladda-btn ladda-button"
					 data-style="zoom-in" 
					 type="submit" ref="submit">Submit</button>
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
	props: ['url', 'grades'],
	components: {
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
			let formData = new FormData(this.$refs.form);
			let animation = ladda.create( this.$refs.submit );
			animation.start();

			axios.post(this.url, formData)
				.then( (response)=>{
					this.grades.push( response.data );
					this.$refs.form.reset();
				} )
					.catch( ( errors )=>{
						this.errors.record( errors.response.data );
					} )
						.then( ()=>{
							animation.stop();
						} );
		}
	},
	beforeRouteEnter(to, from, next){
		next(vm=>{
			// vm.fetchData();
		});
	}
}
</script>
