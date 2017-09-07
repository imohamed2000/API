<template>
	<div class="form-group">
		<label for="year" v-text="$t('Active Academic Year')"></label>
		<select class="form-control" name="year" id="year" v-model="selected">
			<option value="0" disabled selected v-text="$t('Select Year')"></option>
			<option :value="year.id" v-for="year in years" v-text="year.name"></option>
		</select>
	</div>
</template>
<script>

import { mapActions } from 'vuex';
import axios from '../helpers/http';
import Errors from '../helpers/errors';
//import ladda from 'ladda';
//import toastr from '../helpers/toastr.js';
//import $style from '../helpers/style.js';
//let style = new $style();

export default{
	props: ['school'],
	data(){
		return {
			years: [],
			selected: 0
		};
	},
	computed: {
		url: function(){
			return `school/${this.school.id}/years`;
		},
		activeUrl: function(){
			return `school/${this.school.id}/year`;
		},
	},
	mounted(){
		this.fetchData();
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		}),
		fetchData: function(){
			axios.get(this.url).then(response => {
				this.years = response.data;
			});
			axios.get(this.activeUrl)
					.then(response => {
						if(response.data.id !== undefined)
						{
							this.selected = response.data.id;
						}
						
					});
		},
		update: function(){
			if(this.selected != 0){
				let url = `school/${this.school.id}/year/${this.selected}/active`;
				axios.post(url);
			}
		}
	},
	beforeRouteEnter(to, from, next){
		next(vm=>{
			// vm.fetchData();
		});
	}
}
</script>
