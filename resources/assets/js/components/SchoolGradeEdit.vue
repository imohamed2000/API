<template>
	<portlet :props="{ title: $t('Edit Grade'), icon: 'icon-note' }">
		<form ref="form" slot="body" @submit.prevent="onSubmit" @keydown="errors.clear( $event.target.name )">
			<input type="hidden" name="_method" value="PUT">
			<div class="form-group" :class="errors.has('name') ? 'has-error' : '' ">
				<input v-model="name" type="text" name="name" id="name" class="form-control" :placeholder="$t('Grade Name')">
				<p class="help-block" v-text="errors.get('name')"></p>
			</div>
			<div class="row" slot="footer">
				<div class="col-md-12">
					<button class="pull-right btn green mt-ladda-btn ladda-button" 
						data-style="zoom-in" 
						type="submit" 
						ref="submit" v-text="$t('Save')"></button>

					<button class="pull-right btn grey mt-ladda-btn ladda-button" 
					data-style="zoom-in" 
					type="button" 
					ref="cancel" v-text="$t('Cancel')" @click="$emit('cancel')"></button>

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
	props: ['url', 'gradeID', 'gradeName'],
	components: {
		portlet,
	},
	data(){
		return {
			errors: new Errors(),
		};
	},
	computed: {
		name: function(){
			return this.gradeName;
		}
	},
	mounted(){
		this.isLoading(false);
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		}),
		onSubmit: function(){
			let formData = new FormData(this.$refs.form);
			let animation = ladda.create( this.$refs.submit );
			animation.start();

			let ajaxUrl = `${this.url}/${this.gradeID}`;
			axios.post(ajaxUrl, formData)
				.then( response=>{
					this.$parent.$parent.fetchData();
					this.$parent.$parent.editGrade = false;
				} )
					.catch( errors => {
						this.errors.record( errors.response.data );
					})
						.then(()=>{
							animation.stop();
						});
		},
	},
	beforeRouteEnter(to, from, next){
		next(vm=>{
			// vm.fetchData();
		});
	}
}
</script>
