<template>
	<form novalidate @keyup.enter="onSubmit" class="login-form" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">
		<div class="row">
			<div class="col-xs-6">
				<div class="alert alert-danger" v-show="errors.has('email')">
		            <button class="close" data-close="alert"></button>
		            <span v-text="errors.get('email')"></span>
		        </div>
			</div>
			<div class="col-xs-6">
				<div class="alert alert-danger" v-show="errors.has('password')">
		            <button class="close" data-close="alert"></button>
		            <span v-text="errors.get('password')"></span>
		        </div>
			</div>
		</div>
        <div class="row">
            <div class="col-xs-6">
                <input :class="{
                	'form-control form-control-solid placeholder-no-fix form-group': !errors.has('email'),
                	'form-control form-control-solid placeholder-no-fix form-group has-error': errors.has('email')
                	}" type="email" autocomplete="off" :placeholder="$t('Email')" name="email" 
                	v-model="email" />
            </div>
            <div class="col-xs-6">
                <input :class="{
                'form-control form-control-solid placeholder-no-fix form-group': !errors.has('password'),
                'form-control form-control-solid placeholder-no-fix form-group has-error': errors.has('password')
                }" type="password" autocomplete="off" :placeholder="$t('Password')" name="password" 
                v-model="password" />

            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="rem-password">
                    <label class="rememberme mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember" value="1" v-model="remember"/> {{$t('Remember me')}}
                        <span></span>
                    </label>
                </div>
            </div>
            <div class="col-sm-8 text-right">
                <div class="forgot-password">
                    <a href="javascript:;" id="forget-password" class="forget-password">{{$t('Forgot Password?')}}</a>
                </div>
                <button type="submit" class="btn green mt-ladda-btn ladda-button" data-style="zoom-in" :disabled="errors.any()">{{$t('Sign In')}}</button>
            </div>
        </div>
    </form>
</template>
<script>
	import axios from 'axios';
	import Errors from '../helpers/errors';
	import Cookie from 'js-cookie';
	import $Assets from '../helpers/assets.js';
	import ladda from 'ladda';

	let moment = require('moment');
	let Assets = new $Assets();

	export default{
		data(){
			return{
				email: '',
				password: '',
				remember: false,
				errors: new Errors(),
				submitAnimation: null
			}
		},
		methods:{
			onSubmit: function(e){
				this.submitAnimation = ladda.create( document.querySelector('button[type="submit"]') );
				this.submitAnimation.start();

				axios.post('api/v1/login', this.$data)
					.then(response => {
						Cookie.set('isGuest', 'false', {
							expires: this.expires(),
							secure: true
						});
						this.$store.dispatch('toAuth');
						this.submitAnimation.stop();
					})
					.catch(errors => {
						this.errors.record( errors.response.data );
						this.submitAnimation.stop();
					} );
					
			},
			expires: function(){
				let now = this.remember ? moment().add(14, 'days') : moment().add(1, 'hours');
				return now.toDate();
			}

		},
		beforeCreate: function(){
			document.title = this.$t("Odigita LMS ") + " | " + this.$t("Welcome") ;
			document.getElementsByTagName("body")[0].setAttribute('class', "login");
			Assets.addStyle('plugins/ladda/ladda-themeless.min.css');
		},
		destroyed(){
			Assets.removeStyle('plugins/ladda/ladda-themeless.min.css');
		}
	}
</script>