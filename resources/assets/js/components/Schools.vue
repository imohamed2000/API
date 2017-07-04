<template>
	<datatable @rowClick="rowClick" :props="props"></datatable>
</template>
<script>
import {mapActions} from 'vuex';
import datatable from './datatable';

export default{
	data(){
		return{
			props: {
				class: 'table table-striped table-bordered table-hover dt-responsive',
				width: '100%',
				ajax: {
					"url": "/api/v1/schools?datatables",
                    "dataSrc": "original.data"
				},
				columns: [
					{"data" : "name"},
					{"data" : "email"},
					{"data" : "city"},
				],
				headers: [
					{'title' : 'Name', 'class': 'all'},
					{'title' : 'Email', 'class': 'min-phone-l'},
					{'title' : 'City', 'class': 'min-tablet'},
				],
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
