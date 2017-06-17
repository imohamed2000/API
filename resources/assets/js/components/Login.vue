<template>
	<form class="login-form" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">
        <div class="row">
            <div class="col-xs-6">
                <input :class="{
                	'form-control form-control-solid placeholder-no-fix form-group': !errors.has('email'),
                	'form-control form-control-solid placeholder-no-fix form-group has-error': errors.has('email')
                	}" type="email" autocomplete="off" placeholder="Email" name="email" 
                	v-model="email" />

               	 <div class="alert alert-danger" v-show="errors.has('email')">
		            <button class="close" data-close="alert"></button>
		            <span v-text="errors.get('email')"></span>
		        </div>
            </div>
            <div class="col-xs-6">
                <input :class="{
                'form-control form-control-solid placeholder-no-fix form-group': !errors.has('password'),
                'form-control form-control-solid placeholder-no-fix form-group has-error': errors.has('password')
                }" type="password" autocomplete="off" placeholder="Password" name="password" 
                v-model="password" />
				<div class="alert alert-danger" v-show="errors.has('password')">
		            <button class="close" data-close="alert"></button>
		            <span v-text="errors.get('password')"></span>
		        </div>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="rem-password">
                    <label class="rememberme mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember" value="1" v-model="remember"/> Remember me
                        <span></span>
                    </label>
                </div>
            </div>
            <div class="col-sm-8 text-right">
                <div class="forgot-password">
                    <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>
                </div>
                <button class="btn green" type="submit" :disabled="errors.any()">Sign In</button>
            </div>
        </div>
    </form>
</template>
<script>
	import axios from 'axios';
	import Errors from '../helpers/errors';
	import Cookie from 'js-cookie';
	let moment = require('moment');

	export default{
		data(){
			return{
				email: '',
				password: '',
				remember: false,
				errors: new Errors()
			}
		},
		methods:{
			onSubmit: function(e){
				axios.post('api/v1/login', this.$data)
					.then(response => {
						Cookie.set('isGuest', 'false', {
							expires: this.expires(),
							secure: true
						});
						this.$store.dispatch('toAuth');
					})
					.catch(errors => this.errors.record( errors.response.data ) );
			},
			expires: function(){
				let now = this.remember ? moment().add(14, 'days') : moment().add(1, 'hours');
				return now.toDate();
			}

		},
		mounted(){
			document.title = "Odigita LMS| Login";
		}
	}
</script>