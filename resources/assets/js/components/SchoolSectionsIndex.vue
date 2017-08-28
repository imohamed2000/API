<template>
	<portlet :props="{title: $t('Sections'), class: 'solid grey-cararra'}">
		<datatable @deleteElement="deleteSection" @editElement="editSection" :props="table" slot="body" ref="table"></datatable>
	</portlet>
</template>
<script>

import { mapActions } from 'vuex';
import axios from '../helpers/http';
//import Errors from '../helpers/errors';
//import ladda from 'ladda';
import toastr from '../helpers/toastr.js';
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
        			{"data": null, 'fnCreatedCell': (nTd, sData, oData, iRow, iCol)=>{
        				let gradeName = oData.grade ? oData.grade.name : '';
        				jQuery(nTd).html(gradeName);
        			}},
        			{"data": null, 'fnCreatedCell': (nTd, sData, oData, iRow, iCol)=>{
        				let editBtn = `
							<li>
								<a class="edit-element">
									<i class="icon-note"></i>
                                    ${window.app.$t('Edit')}
								</a>
							</li>
        				`;
        				let deleteBtn = `
							<li>
								<a class="font-red delete-element">
                                <i class="font-red icon-trash"></i>
                                ${window.app.$t('Delete')}
                                </a>
							</li>
        				`;
        				let tools = `<div class="btn-group">
										<button class="btn green btn-xs btn-outline dropdown-toggle" data-toggle="dropdown">
											${window.app.$t('Tools')}
											<i class="fa fa-angle-down"></i>
										</button>
										<ul class="dropdown-menu pull-right">
											${editBtn}
											${deleteBtn}
										</ul>
									</div>`;
        				jQuery(nTd).html(tools);
        			}}
        		],
        		columnDefs: [{
        			"searchable": false,
		            "orderable": false,
		            "targets": [0,3]
        		}],
        		index:{
        			present: true,
        			title: this.$t('ID'),
        			class: 'index'
        		},
			};
		}
	},
	mounted(){
		
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		}),
		deleteSection: function(event, data, row){
			let oThis = this;
			let url = `${this.url}/${data.id}`; 
			bootbox.confirm({
				title: oThis.$t('Delete a section'),
				message: oThis.$t('Are you sure, you want to delete this section?'),
				buttons: {
					confirm: {
						label: '<i class="icon-trash"></i> ' + oThis.$t('Delete'),
						className: 'btn-danger'
					}
				},
				callback: function(confirm){
					if(confirm){
						axios.delete(url)
							.then(resp=>{
								toastr.warning(
										oThis.$t('Section was deleted successfully!'),
										oThis.$t('Deleted a section')
									);
								oThis.$emit('updated');
							});
					}
				}
			});
			this.$emit('updated');
		},
		editSection: function(event, data, row){
			this.$parent.$parent.editSection = true;

			this.$parent.$parent.activeSectionName      = data.name;
			this.$parent.$parent.activeSectionGradeID   = data.grade.id;
			this.$parent.$parent.activeSectionID	 	= data.id;
			
		},
	},
	beforeRouteEnter(to, from, next){
		next(vm=>{
			// vm.fetchData();
		});
	}
}
</script>
