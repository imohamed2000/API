<template>
	<portlet :props="{title: $t('Grades'), class: 'solid grey-cararra'}">
		<ol class="dd-list" slot="body">
			<draggable :list="grades" :options="{draggable:'.item', sort:true}" @sort="onSort">
					<li :data="JSON.stringify(element)" @contextmenu="contextMenu"
						:order="element.order" 
						v-for="element in grades" 
						:key="element.id" 
						class="dd-item dd3-item item has-context-menu grabbable">
						<div :data="JSON.stringify(element)" class="dd-handle dd3-handle has-context-menu"> </div>
						<div :data="JSON.stringify(element)" class="dd3-content has-context-menu"> {{element.name}} </div>
					</li>
			</draggable>
		</ol>

		<ul slot="footer" v-for="element in grades" :id="`context-menu-${element.id}`" class="dropdown-menu context-menu">
		    <li @click.prevent="onEdit($event, element)">
		    	<a href="#">
		    		<i class="icon-note"></i> {{ $t('Edit') }}
		    	</a>
		    </li>
		    <li @click.prevent="onDelete($event, element)">
		    	<a class="font-red" href="#">
		    		<i class="icon-trash font-red"></i> {{ $t('Delete') }}
		    	</a>
		    </li>
		</ul>	
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
		// Hide all context menus with ccick and scroll event
		document.addEventListener('click', this.hideContextMenus);
		document.addEventListener('scroll', this.hideContextMenus);
		
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
		},
		onEdit: function(e, element){
			this.$emit('edit', element);
		},
		onDelete: function(e, element){
			this.$emit('delete', element);
		},
		contextMenu: function(e){
			if( e.target.classList.contains('has-context-menu') ){
				e.preventDefault();
				let grade = JSON.parse(e.target.getAttribute('data'));
				this.hideContextMenus();
				let menu = document.getElementById(`context-menu-${grade.id}`);

				menu.style.left = `${e.clientX}px`;
				menu.style.top = `${e.clientY - 20}px`;

				menu.classList.add('open');
			}
		},
		hideContextMenus: function(){
			document.querySelectorAll('.context-menu').forEach( function(element, index) {
				element.classList.remove('open');
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
<style>
	.dd-item{
		position: relative;
	}
	.context-menu{
		position: fixed;
		z-index: 99999 !important;
	}
	.open{
		display: block;
	}
</style>
