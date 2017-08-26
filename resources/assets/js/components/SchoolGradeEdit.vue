<template>
	<portlet :props="{ title: $t('Edit Grade'), icon: 'icon-note' }">
		<form ref="form" slot="body" @submit.prevent="onSubmit" @keydown="errors.clear( $event.target.name )">
			<div class="form-group">
				<input v-model="gradeName" type="text" name="name" id="name" class="form-control" :placeholder="$t('Grade Name')">
				<p class="help-block"></p>
			</div>
			<div class="row" slot="footer">
				<div class="col-md-12">
					<button class="pull-right btn green mt-ladda-btn ladda-button" 
						data-style="zoom-in" 
						type="submit" 
						ref="submit" v-text="$t('Save')"></button>
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

	},
	mounted(){
		this.isLoading(false);
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		}),
		onSubmit: function(){
			
		},
	},
	beforeRouteEnter(to, from, next){
		next(vm=>{
			// vm.fetchData();
		});
	}
}
</script>
