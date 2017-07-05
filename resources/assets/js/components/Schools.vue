<template>
	<datatable @rowClick="rowClick" :props="props"></datatable>
</template>
<script>
import {mapActions} from 'vuex';
import datatable from './datatable';
import jQuery from 'jquery';

export default{
	data(){
		return{
			props: {
				class: 'table table-striped table-bordered table-hover dt-responsive',
				width: '100%',
				ajax: {
					"url": "/api/v1/schools?datatables",
				},
				columns: [
					{"data": "DT_Row_Index"},
					{"data" : "name", "fnCreatedCell": function( nTd, sData, oData, iRow, iCol ){
						jQuery(nTd).html(`<a href="/schools/${oData.name}">${sData}</a>`);
					}},
					{"data" : "email"},
					{"data" : "city"},
				],
				headers: [
					{'title': 'ID', 'class': 'index'},
					{'title' : 'Name', 'class': 'all'},
					{'title' : 'Email', 'class': 'min-phone-l'},
					{'title' : 'City', 'class': 'min-tablet'},
				],
				processing: true,
        		serverSide: true,
        		index: {
        			withIndex: true,
        			title: 'ID',
        			class: 'index'
        		},
        		columnDefs: [{
        			"searchable": false,
		            "orderable": false,
		            "targets": 0
        		}],
        		order: [[ 1, 'asc' ]],
        		fixedColumns: true
			}
		}
	},
	components:{
		datatable: datatable
	},
	created(){
		this.fetchData();
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		}),
		fetchData(){
			this.isLoading(false);
		},
		watch:{
			'$route': 'fetchData'
		},
		rowClick: function(event, data, row){
			console.log(event, data, row)
		}
	},
}
</script>
