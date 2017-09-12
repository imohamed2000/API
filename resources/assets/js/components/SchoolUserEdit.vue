<template>
	<div v-if="user">
		<portlet :props="portlet">
			<form enctype="multipart/form-data" slot="body" @submit.prevent="onSubmit" ref="form" @keydown="errors.clear($event.target.name)"> 
				<input type="hidden" name="_method" value="PUT">
				<div class="row">
					<div class="col-md-9">
						<!-- First Row -->
						<div class="row">
							<div class="col-md-4">
								<div class="form-group" :class=" errors.has('title') ? 'has-error' : '' ">
									<label for="title" v-text="$t('Title')"></label>
									<input v-model="user.title" type="text" name="title" class="form-control" id="title" :placeholder="$t('Mr, Mrs, and etc')">
									<p v-if="errors.has('title')" class="help-block" v-text="errors.get('title')"></p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group" :class=" errors.has('first_name') ? 'has-error' : '' ">
									<label for="first-name" v-text="$t('First Name')"></label>
									<input v-model="user.first_name" type="text" name="first_name" class="form-control" id="first-name" :placeholder="$t('First Name')">
									<p class="help-block" v-if="errors.has('first_name')" v-text="errors.get('first_name')"></p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group" :class=" errors.has('last_name') ? 'has-error' : '' ">
									<label for="last-name" v-text="$t('Last Name')"></label>
									<input v-model="user.last_name" type="text" name="last_name" class="form-control" id="last-name" :placeholder="$t('Last Name')">
									<p class="help-block" v-if="errors.has('last_name')" v-text="errors.get('last_name')"></p>
								</div>
							</div>
						</div>
						<!-- Second Row -->
						<div class="row">
							<div class="col-md-6">
								<div class="form-group" :class="errors.has('email') ? 'has-error' : '' ">
									<label for="email" v-text="$t('Email')"></label>
									<input v-model="user.email" type="email" name="email" id="email" class="form-control" :placeholder="$t('Email')">
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
									<select  v-model="user.gender" name="gender" id="gender" class="form-control" @change="onGenderChange">
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
									<select  v-model="user.role.id" name="role" id="role" class="form-control" @change="errors.clear('role')">
										<option value="0" v-text="`_`+$t('Select Role')"></option>
										<option v-for="role in $parent.$parent.school.roles" :value="role.id" v-text="role.name"></option>
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
									<textarea v-model="user.address" name="address" id="address" class="form-control" :placeholder="$t('Address')"></textarea>
									<p class="help-block" v-text="errors.get('address')"></p>
								</div>
							</div>
						</div>
						<!-- Fifth Row -->
						<div class="row">
							<div class="col-md-6">
								<div class="form-group" :class="errors.has('phone') ? 'has-error' : '' ">
									<label for="phone" v-text="$t('Phone')"></label>
									<input v-model="user.phone" type="phone" name="phone" id="phone" class="form-control" :placeholder="$t('Phone')">
									<p class="help-block" v-text="errors.get('phone')"></p>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group" :class="errors.has('birth_date') ? 'has-error': ''">
									<label for="birth-date" v-text="$t('Birth Date')"></label>
									<input v-model="user.birth_date" @change="errors.clear('birth_date')" type="date" name="birth_date" id="birth-date" class="form-control" :placeholder="$t('Birth Date')">
									<p class="help-block" v-text="errors.get('birth_date')"></p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group" :class="errors.has('avatar') ? 'has-error' : ''">
							<image-upload 
							ref="imageUpload"
							 @clear="clearAvatar = 'true'"
							 @change="clearAvatar = ''"
							 @clearErrors="errors.clear('avatar')"
							:props="imageUpload" ></image-upload>
							<p class="help-block" v-text="errors.get('avatar')"></p>
						</div>
						<input type="hidden" name="clear_avatar" v-model="clearAvatar">
					</div>
				</div>

				<div slot="footer" class="text-right">
					<button type="submit" class="btn green mt-ladda-btn ladda-button" data-style="zoom-in" ref="submitBtn" v-text="$t('Submit')"></button>
				</div>
			</form>
		</portlet>
		<StudentMap v-if="roleSlug == 'student'" :school="school" :user="user"></StudentMap>
	</div>

</template>
<script>

import { mapActions, mapState } from 'vuex';
import Portlet from './Portlet';
import axios from '../helpers/http';
import Errors from '../helpers/errors';
import ladda from 'ladda';
import toastr from '../helpers/toastr.js';
import ImageUpload from './ImageUpload';
import StudentMap from './StudentMap';

let randomString = require("randomstring");
import Vue from 'vue';
//import $style from '../helpers/style.js';
//let style = new $style();

export default{
	props: ['user'],
	components: {
		portlet: Portlet,
		imageUpload: ImageUpload,
		StudentMap
	},
	data(){
		return {
			clearAvatar: '',
			errors: new Errors(),
			submitAnimation: null,
		};
	},
	computed: {
		portlet: function(){
			let portlet = {
				title: this.user.name,
				icon: 'icon-user'
			};
			return portlet;
		},
		imageUpload: function(){
			return {
				currentFile: this.$parent.user.avatar_url,
				defaultImage: '/img/male.png',
				name: 'avatar'
			};
		},
		ajaxUrl: function(){
			return `/school/${this.$parent.$parent.school.id}/users/${this.$parent.user.id}`;
		},
		roleSlug: function(){
			return this.user.role.name.toLowerCase();
		},
		school: function(){
			return this.$parent.$parent.school;
		}
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
			let formData = new FormData(this.$refs.form);
			this.submitAnimation = ladda.create( this.$refs.submitBtn );
			this.submitAnimation.start();

			axios.post(this.ajaxUrl, formData)
				.then((response)=>{
					Vue.set(this.$parent, 'user',  response.data );
					toastr.success(
							this.$t('This user data is successfully updated!'),
							this.$t('Successfully updated')
						);
				})
					.catch(errors => {
						this.errors.record( errors.response.data );
					})
						.then(()=>{
							this.submitAnimation.stop();
						});
		},
		setPageTitle(){
			let pageTitle = `${this.user.first_name} ${this.user.last_name} (${this.$t('Settings')})`;
			setTitle(this, pageTitle, pageTitle);
		}
	},
	watch: {
		'user.first_name': function(newVal, oldVal){
			this.setPageTitle();
		},
		'user.last_name': function(newVal, oldVal){
			this.setPageTitle();
		},
	},
	beforeRouteEnter(to, from, next){
		next(vm=>{
			// vm.$parent.fetchData();
		});
	}
}
</script>
