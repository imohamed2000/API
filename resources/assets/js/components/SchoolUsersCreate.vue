<template>
	<modal :props="modal" ref="createModal">
		<h4 class="modal-title" slot="modal-title" v-text="$t('Add new user')"></h4>
		<div slot="modal-content">
			<form enctype="multipart/form-data" ref="createUserForm" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-9">
							<!-- First Row -->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group" :class=" errors.has('title') ? 'has-error' : '' ">
										<label for="title" v-text="$t('Title')"></label>
										<input type="text" name="title" class="form-control" id="title" :placeholder="$t('Mr, Mrs, and etc')">
										<p v-if="errors.has('title')" class="help-block" v-text="errors.get('title')"></p>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group" :class=" errors.has('first_name') ? 'has-error' : '' ">
										<label for="first-name" v-text="$t('First Name')"></label>
										<input type="text" name="first_name" class="form-control" id="first-name" :placeholder="$t('First Name')">
										<p class="help-block" v-if="errors.has('first_name')" v-text="errors.get('first_name')"></p>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group" :class=" errors.has('last_name') ? 'has-error' : '' ">
										<label for="last-name" v-text="$t('Last Name')"></label>
										<input type="text" name="last_name" class="form-control" id="last-name" :placeholder="$t('Last Name')">
										<p class="help-block" v-if="errors.has('last_name')" v-text="errors.get('last_name')"></p>
									</div>
								</div>
							</div>
							<!-- Second Row -->
							<div class="row">
								<div class="col-md-6">
									<div class="form-group" :class="errors.has('email') ? 'has-error' : '' ">
										<label for="email" v-text="$t('Email')"></label>
										<input type="email" name="email" id="email" class="form-control" :placeholder="$t('Email')">
										<p class="help-block" v-text="errors.get('email')"></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group" :class="errors.has('password') ? 'has-error' : ''">
										<label for="password" v-text="$t('Password')"></label>
										<div class="input-group">
											<input ref="password" type="text" name="password" id="password" class="form-control" :placeholder="$t('Keep it secret ;)')">
											<span class="input-group-btn">
											 	<a @click.prevent="togglePassword" href="#"  class="btn green">
                                                	<i ref="eyeIcon" class="ion ion-eye-disabled"></i>
                                            	</a>
											</span>
										</div>
										<p class="help-block" v-text="errors.get('password')"></p>
										<p class="help-block"><a @click.prevent="generatePassword" href="#" v-text="$t('Generate a strong one')"></a></p>
									</div>
								</div>
							</div>
							<!-- Third Row -->
							<div class="row">
								<div class="col-md-6">
									<div class="form-group" :class="errors.has('gender') ? 'has-error' : ''">
										<label for="gender" v-text="$t('Gender')"></label>
										<select name="gender" id="gender" class="form-control" @change="onGenderChange">
											<option value="0" v-text="`_` + $t('Select Gender')"></option>
											<option value="male" v-text="$t('Male')"></option>
											<option value="female" v-text="$t('Female')"></option>
										</select>
										<p class="help-block" v-text="errors.get('gender')"></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group" :class="errors.has('role') ? 'has-error' : ''">
										<label for="role" v-text="$t('Role')"></label>
										<select name="role" id="role" class="form-control" @change="errors.clear('role')">
											<option value="0" v-text="`_`+$t('Select Role')"></option>
											<option v-for="role in $parent.school.roles" :value="role.id" v-text="role.name"></option>
										</select>
										<p class="help-block" v-text="errors.get('role')"></p>
									</div>
								</div>
							</div>
							<!-- Forth Row -->
							<div class="row">
								<div class="col-md-12">
									<div class="form-group" :class="errors.has('address') ? 'has-error' : '' ">
										<label for="address" v-text="$t('Address')"></label>
										<textarea name="address" id="address" class="form-control" :placeholder="$t('Address')"></textarea>
										<p class="help-block" v-text="errors.get('address')"></p>
									</div>
								</div>
							</div>
							<!-- Fifth Row -->
							<div class="row">
								<div class="col-md-6">
									<div class="form-group" :class="errors.has('phone') ? 'has-error' : '' ">
										<label for="phone" v-text="$t('Phone')"></label>
										<input type="phone" name="phone" id="phone" class="form-control" :placeholder="$t('Phone')">
										<p class="help-block" v-text="errors.get('phone')"></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group" :class="errors.has('birth_date') ? 'has-error': ''">
										<label for="birth-date" v-text="$t('Birth Date')"></label>
										<input @change="errors.clear('birth_date')" type="date" name="birth_date" id="birth-date" class="form-control" :placeholder="$t('Birth Date')">
										<p class="help-block" v-text="errors.get('birth_date')"></p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group" :class="errors.has('avatar') ? 'has-error' : ''">
								<image-upload 
								ref="imageUpload"
								 @clearErrors="errors.clear('avatar')"
								:props="imageUpload" ></image-upload>
								<p class="help-block" v-text="errors.get('avatar')"></p>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" @click="modal.show = false" v-text="$t('close')"></button>
					<button type="submit" class="btn green mt-ladda-btn ladda-button" data-style="zoom-in" ref="createUserSubmitBtn" v-text="$t('Submit')"></button>
				</div>
			</form>
		</div>
	</modal>
</template>
<script>
import { mapActions} from 'vuex';
import axios from '../helpers/http';
import Errors from '../helpers/errors';
import ladda from 'ladda';
import toastr from '../helpers/toastr.js';

let randomString = require("randomstring");

import modal from './Modal';
import ImageUpload from './ImageUpload';

export default{
	data(){
		return {
			modal: {
				id: 'school-user-create',
				show: false,
				size: 'large'
			},
			imageUpload: {
				currentFile: null,
				defaultImage: '/img/male.png',
				name: 'avatar'
			},
			errors: new Errors(),
			submitAnimation: null,
		}
	},
	components: {
		modal:modal,
		imageUpload: ImageUpload
	},
	mounted(){
		this.isLoading(false);
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		}),
		changeAvatar: function(e){
			if(e.target.value == 'female'){
				this.imageUpload.defaultImage = '/img/female.png';
			}else{
				this.imageUpload.defaultImage = '/img/male.png';
			}
		},
		onGenderChange: function(e){
			this.changeAvatar(e);
			this.errors.clear('gender');
		},
		generatePassword: function(){
			let password = randomString.generate({
				length: 11,
				charset: 'alphanumeric'
			});

			this.$refs.password.value = password;
			this.errors.clear('password');
		},
		togglePassword: function(){
			let type = (this.$refs.password.getAttribute('type') == 'text') ? 'password' : 'text';
			let icon = (this.$refs.eyeIcon.getAttribute('class') == 'ion ion-eye-disabled') ? 'ion ion-eye' : 'ion ion-eye-disabled';
			this.$refs.password.setAttribute('type', type);
			this.$refs.eyeIcon.setAttribute('class', icon);
		},
		onSubmit: function(){
			// Start submit button loading animation
			this.submitAnimation = ladda.create( this.$refs.createUserSubmitBtn);
			this.submitAnimation.start();

			// Get form data
			let formData = new FormData( this.$refs.createUserForm );
			let url = `school/${this.$parent.school.id}/users`;
			
			// Sending ajax request
			axios.post(url, formData)
					.then((response)=>{
						// Reset Form
						this.resetForm();
						// Refresh Table
						this.$parent.$refs.datatable.refresh();
						// Show toastr
						toastr.info(
								this.$t('New user added to this school'),
								this.$t('New user!')
							);
					})
						.catch( error=>{
							this.errors.record( error.response.data );
						})
							.then(()=>{
								this.submitAnimation.stop();
								
							});
		},
		resetForm: function(){
			// Reset all fields except image upload
			jQuery(this.$refs.createUserForm).find(':input').each(function(i,input){
				if( input.getAttribute('name') != 'avatar'){
					if(input.tagName.toLowerCase() == 'select'){
						input.value = 0;
					}else{
						input.value = '';
					}
				}
			});
			// Reset image upload
			this.$refs.imageUpload.reset();
			// Reset default avatar img
			this.imageUpload.defaultImage = '/img/male.png';
		}
	}
}
</script>