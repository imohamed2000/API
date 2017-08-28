<template>
	<portlet :props="{ title: $t('Edit Section'), icon: 'icon-note' }">
		<form slot="body" ref="form" @submit.prevent="onSubmit">
			<input type="hidden" name="_method" value="PUT">
			<div class="form-group" :class="errors.has('name') ? 'has-error' : '' ">
				<label for="section-name" v-text="$t('Name')"></label>
				<input v-model="name" @keydown="errors.clear('name')" type="text" name="name" id="section-name" class="form-control" :placeholder="$t('Section Name')">
				<p class="help-block" v-text="errors.get('name')"></p>
			</div>
			<div class="form-group" :class="errors.has('grade_id') ? 'has-error' : '' ">
				<label for="grade-id" v-text="$t('Grade')"></label>
				<select v-model="gradeID" @change="errors.clear('grade_id')"
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

import portlet from './Portlet';
export default{
	props: ['url', 'section', 'sectionName', 'grade'],
	components: {
		portlet,
	},
	data(){
		return {
			errors: new Errors(),
		};
	},
	computed: {
		sectionID: function(){
			return this.section;
		},
		name: function(){
			return this.sectionName;
		},
		gradeID: function(){
			return this.grade;
		},
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
			let url = `${this.url}/${this.sectionID}`;
			let oThis = this;
			animation.start();

			axios.post(url, formData)
					.then( reps=>{
						this.$emit('updated');
						this.$parent.$parent.editSection = false;
						toastr.info(
								oThis.$t('Section is updated successfully!'),
								oThis.$t('Section Updated!'),
							);
					})
						.catch(err =>{
							this.errors.record( err.response.data );
						})
							.then( resp=>{
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
