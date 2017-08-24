<template>
	<portlet :props="{title: $t('Grades'), class: 'solid grey-cararra'}">
		<ol class="dd-list" slot="body">
			<draggable :list="grades" :options="{draggable:'.item', sort:true}" @sort="onSort">
					<li :order="element.order" v-for="element in grades" :key="element.id" class="dd-item dd3-item item">
						<div class="dd-handle dd3-handle"> </div>
						<div class="dd3-content"> {{element.name}} </div>										
					</li>
			</draggable>
		</ol>
	</portlet>
</template>
<script>

import { mapActions } from 'vuex';
import axios from '../helpers/http';
//import Errors from '../helpers/errors';
//import ladda from 'ladda';
//import toastr from '../helpers/toastr.js';
//import $style from '../helpers/style.js';
//let style = new $style();

import portlet from './Portlet';
import draggable from 'vuedraggable';

export default{
	props: ['grades', 'url'],
	components: {
		portlet,
		draggable,
	},
	data(){
		return {
			
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
		onSort: function(){
			// Ordering grades
			let order = 0;
			this.grades.forEach( function(element, index) {
				element.order = order;
				order ++;
			});

			// Sending ajax request
			let url = `${this.url}/sort`;
			axios.post(url, {grades: this.grades})
				.then( (response)=>{
					this.$parent.grades = response.data;
				} );
		}
	},
	beforeRouteEnter(to, from, next){
		next(vm=>{
			// vm.fetchData();
		});
	}
}
</script>
