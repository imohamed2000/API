<template>
	<form enctype="multipart/form-data" ref="form" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">
		<input type="hidden" name="_method" value="PUT">
		<div :class="{'form-group': !errors.has('name'), 'form-group has-error': errors.has('name')}">
	
			<div class="row">
				<div class="col-md-9">
					<div :class="{'form-group': !errors.has('name'), 'form-group has-error': errors.has('name')}">
						<label for="edit-name" v-text="$t('School Name')"></label>
						<input v-model="school.name" name="name" type="text" class="form-control" id="edit-name" :placeholder="$t('School Name')">
						<p class="help-block" v-text="errors.get('name')"></p>
					</div>

					<div :class="{'form-group': !errors.has('name'), 'form-group has-error': errors.has('name')}">
						<label for="edit-address" v-text="$t('Address')"></label>
						<textarea v-model="school.address" name="address" id="edit-address" class="form-control" :placeholder="$t('Address')"></textarea>
						<p class="help-block" v-text="errors.get('address')"></p>
					</div>
				</div>
				<div class="col-md-3">
					<div :class="{'form-group': !errors.has('name'), 'form-group has-error': errors.has('name')}">
						<image-upload
							ref="imageUpload" 
							:props="imageUpload" 
							@clearErrors="clearUE"
							@clear="onClear"
							@change="onChange">
							</image-upload>
						<p class="help-block" v-text="errors.get('logo')"></p>
						<input type="hidden" name="clear_logo" ref="clearLogo">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div :class="{'form-group': !errors.has('slug'), 'form-group has-error': errors.has('slug')}">
						<label for="edit-slug" v-text="$t('Slug or sub-domain')"></label>
						<input v-model="school.slug" type="text" name="slug" id="edit-slug" class="form-control" :placeholder="$t('Slug or sub-domain')">
						<p class="help-block" v-text="errors.get('slug')"></p>
					</div>

					<div :class="{'form-group': !errors.has('city'), 'form-group has-error': errors.has('city')}">
						<label for="edit-city" v-text="$t('City')"></label>
						<input v-model="school.city" type="text" name="city" id="edit-city" class="form-control" :placeholder="$t('City')">
						<p class="help-block" v-text="errors.get('city')"></p>
					</div>
				</div>
				<div class="col-md-6">
					<div :class="{'form-group': !errors.has('email'), 'form-group has-error': errors.has('email')}">
						<label for="edit-email" v-text="$t('Email')"></label>
						<input v-model="school.email" type="email" name="email" id="edit-email" class="form-control" :placeholder="$t('Email')">
						<p class="help-block" v-text="errors.get('email')"></p>
					</div>

					<div :class="{'form-group': !errors.has('zip'), 'form-group has-error': errors.has('zip')}">
						<label for="edit-zip" v-text="$t('Zip')"></label>
						<input v-model="school.zip" type="text" name="zip" id="edit-zip" class="form-control" :placeholder="$t('Zip')">
						<p class="help-block" v-text="errors.get('zip')"></p>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<button ref="submitBtn" id="edit-school-submit-btn" 
						type="submit" data-style="zoom-in" 
						class="pull-right btn green mt-ladda-btn ladda-button"
						v-text="$t('Submit')">
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</template>
<script>
import { mapActions} from 'vuex';
import ImageUpload from './ImageUpload';

import axios from '../helpers/http';
import Errors from '../helpers/errors';

import jQuery from 'jquery';
import ladda from 'ladda';

export default{
	props: ['school'],
	data(){
		return {
			errors: new Errors(),
		}
	},
	components: {
		'image-upload': ImageUpload
	},
	computed: {
		imageUpload: function(){
			let logo = (this.school.logo_id == 3) ? null : this.school.logo;
			return {
				currentFile: logo,
				defaultImage: '/img/school.png',
				name: 'logo'
			};
		}
	},
	mounted(){
		this.isLoading(false);
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		}),
		clearUE: function(){

		},
		onClear: function(){
			this.$refs.clearLogo.value = 'true';
		},
		onChange: function(){
			this.$refs.clearLogo.value = '';
		},
		onSubmit: function(){
			let submitAnimation = ladda.create( this.$refs.submitBtn );
			submitAnimation.start();
			let oThis = this;
			axios.post('/schools/' + this.school.id, new FormData(this.$refs.form))
				.then((res)=>{

					let options = require('../helpers/toastr.js');
					toastr.options = options.default;
					toastr.success(	
						oThis.$t("This school data is successfully updated!"), 
						oThis.$t("Successfully updated") 
						);
					
					jQuery(this.$refs.imageUpload.$refs.input).val(()=>{
						return this.defaultValue;
					});
				})
					.catch((err)=>{
						this.errors.record( err.response.data );
					})
					.then(()=>{
						submitAnimation.stop();
					});
		}
	},
}
</script>