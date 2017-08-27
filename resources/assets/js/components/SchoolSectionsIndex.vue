<template>
	<portlet :props="{title: $t('Sections'), class: 'solid grey-cararra'}">
		<datatable :props="table" slot="body" ref="table"></datatable>
	</portlet>
</template>
<script>

import { mapActions } from 'vuex';
//import axios from '../helpers/http';
//import Errors from '../helpers/errors';
//import ladda from 'ladda';
//import toastr from '../helpers/toastr.js';
//import $style from '../helpers/style.js';
//let style = new $style();

import portlet from './Portlet';
import datatable from './datatable';

export default{
	props: ['url'],
	components: {
		portlet,
		datatable
	},
	data(){
		return {
			
		};
	},
	computed: {
		table: function(){
			let url = `/api/v1${this.url}?datatables`;
			return {
				class: 'table table-striped table-bordered table-hover dt-responsive',
				width: '100%',
				processing: true,
    			serverSide: true,
        		lengthMenu: [25, 50, 75, 100 ],
        		ajax:{ url: url},
        		headers: [
        			{title: 'Name', class: ''},
        			{title: 'Grade', class: ''},
        			{title: 'Actions', class: ''},
        		],
        		columns: [
        			{"data": "name"},
        			{"data": "grade.name"},
        			{"data": "name"}
        		],
			};
		}
	},
	mounted(){
		let url = `api/v1${this.url}?datatable`;
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		}),
	},
	beforeRouteEnter(to, from, next){
		next(vm=>{
			// vm.fetchData();
		});
	}
}
</script>
