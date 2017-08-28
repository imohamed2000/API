<template>
	<portlet :props="{title: $t('New Section'), class:'solid grey-cararra', icon:'icon-plus'}">
		<form slot="body" ref="form" @submit.prevent="onSubmit">
			<div class="form-group" :class="errors.has('name') ? 'has-error' : '' ">
				<label for="section-name" v-text="$t('Name')"></label>
				<input @keydown="errors.clear('name')" type="text" name="name" id="section-name" class="form-control" :placeholder="$t('Section Name')">
				<p class="help-block" v-text="errors.get('name')"></p>
			</div>
			<div class="form-group" :class="errors.has('grade_id') ? 'has-error' : '' ">
				<label for="grade-id" v-text="$t('Grade')"></label>
				<select @change="errors.clear('grade_id')"
						 name="grade_id" 
						 id="grade-id" 
						 class="form-control">
					<option value="" disabled selected v-text="$t('Select Grade')"></option>
    				<option :value="grade.id"
    					 v-for="grade in this.$parent.$parent.grades" 
    					 v-text="grade.name"></option>
				</select>
				<p class="help-block" v-text="errors.get('grade_id')"></p>
			</div>
			<div class="row" slot="footer">
				<div class="col-md-12">
					<button class="pull-right btn green mt-ladda-btn ladda-button"
					 data-style="zoom-in" 
					 type="submit"
					 ref="submit" v-text="$t('Submit')"></button>
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

import portlet from './Portlet';

export default{
	props: ['url'],
	components: {
		portlet,
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
			let oThis = this;
			axios.post(this.url, formData)
					.then( response=>{
						this.$refs.form.reset();
						this.$emit('updated');
						toastr.success(
							oThis.$t('Section is created succesfully!'),
							oThis.$t('New Section Created')
						);
					} )
						.catch( err => {
							this.errors.record( err.response.data );
						})
							.then( ()=>{
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
