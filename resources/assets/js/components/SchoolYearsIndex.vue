<template>
	<portlet :props="{title: 'Manage Academic years', icon: 'icon-settings'}">
			<div class="row" slot="body">
				<div class="col-md-8">
					<portlet :props="{title: $t('All Academic years'), class:'solid grey-cararra', icon:'ion ion-flag'}">
						<datatable ref="table" slot="body" :props="table" @editElement="onEdit" @deleteElement="onDelete"></datatable>
					</portlet>
				</div>
				<div class="col-md-4">
					<create v-if="!edit" :school="school" @created="onUpdate"></create>
					<edit v-if="edit" :school="school" :year="year" @cancel="edit=false" @updated="onUpdate"></edit>
				</div>
			</div>
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
import create from './SchoolYearsCreate';
import edit from './SchoolYearsEdit';

export default{
	props: ['school'],
	components:{
		portlet,
		datatable,
		create,
		edit
	},
	data(){
		return {
			edit: false,
			year: {}
		};
	},
	computed: {
		table : function(){
			let ajaxUrl = `/api/v1/school/${this.school.id}/years?datatables`;
			return {
				class: 'table table-striped table-bordered table-hover dt-responsive',
				width: '100%',
				processing: true,
    			serverSide: true,
        		lengthMenu: [25, 50, 75, 100 ],
				ajax:{ url: ajaxUrl},
				headers: [{'title': 'Name', 'class': ''}, {'title': 'Actions', 'class': ''}],
				columns: [{"data": "name"}, {"data": null, 'fnCreatedCell': (nTd, sData, oData, iRow, iCol)=>{
					// edit btn
					let editBtn = `
							<li>
								<a class="edit-element">
                                <i class="icon-trash"></i>
                                ${window.app.$t('Edit')}
                                </a>
							</li>
					`;
					// delete btn
					let deleteBtn = `
							<li>
								<a class="font-red delete-element">
                                <i class="font-red icon-trash"></i>
                                ${window.app.$t('Delete')}
                                </a>
							</li>
					`;
					let tools = `
							<div class="btn-group">
									<button class="btn green btn-xs btn-outline dropdown-toggle" data-toggle="dropdown">
										${window.app.$t('Tools')}
										<i class="fa fa-angle-down"></i>
									</button>
									<ul class="dropdown-menu">
							${editBtn} ${deleteBtn}
							</ul>
								</div>
							`;
					jQuery(nTd).html(tools);
				}}],
				columnDefs: [{
        			"searchable": false,
		            "orderable": false,
		            "targets": [0,2]
        		}],
				index:{
        			present: true,
        			title: this.$t('ID'),
        			class: 'index'
        		},
			};
		},
	},
	mounted(){
		
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		}),
		onEdit: function(event, data, row){
			this.year = data;
			this.edit = true;
		},
		onDelete: function(event, data, row){
			let oThis = this;
			let url = `school/${this.school.id}/years/${data.id}`;

			//confirmation and action
			bootbox.confirm({
				title: oThis.$t('Move this year to trash!'),
				message: oThis.$t('Are you sure you want to move this year to trash?'),
				buttons: {
					confirm: {
						label: '<i class="icon-trash"></i> ' + app.$t('Move to trash'),
						className: 'btn-danger'
					}
				},
				callback: (result)=>{
					if(result){
						axios.delete( url )
								.then(response => {
									oThis.onUpdate();
									toastr.info(
											oThis.$t('Year moved to trash !'),
											oThis.$t('Trashed!')
										);
								});
					}
				}
			});

		},
		onUpdate: function(){
			this.$emit('update');
			this.$refs.table.refresh();
		}
	},
	beforeRouteEnter(to, from, next){
		next(vm=>{
			// vm.fetchData();
		});
	}
}
</script>
