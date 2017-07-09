<template>
	<div>
		<portlet :props="portlet">
			<div slot="tools">
				<button type="button" class="btn green" v-html="btns.create" @click.prevent="showCreateModal"></button>
				<button type="button" class="btn blue" @click.prevent="showImportModal" v-html="btns.import"></button>
			</div>
			<datatable slot="body" @rowClick="rowClick" :props="table"></datatable>
		</portlet>
	</div>
</template>
<script>
import {mapActions} from 'vuex';
import datatable from './datatable';
import portlet from './portlet';
import jQuery from 'jquery';
import axios from './../helpers/http';
// require('../helpers/bootbox');

export default{
	data(){
		return{
			table: {
				class: 'table table-striped table-bordered table-hover dt-responsive',
				width: '100%',
				ajax: {
					"url": "/api/v1/schools?datatables",
				},
				columns: [
					{"data": "name", "fnCreatedCell": ( nTd, sData, oData, iRow, iCol )=>{
						jQuery(nTd).html(`<a href="/schools/${oData.slug}" class="router-link">${sData}</a>`);
					}},
					{"data" : "email"},
					{"data" : "city"},
					{"data": null, "fnCreatedCell": ( nTd, sData, oData, iRow, iCol )=>{
						let viewBtn = `
										<li>
											<a class="router-link" href="/schools/${oData.slug}">
	                                        <i class="icon-eye"></i>
	                                        ${window.app.$t('View')}
	                                        </a>
										</li>
									`;
						let editBtn = `
										<li>
											<a class="router-link" href="/schools/${oData.slug}/edit">
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
						let tools = `
									<div class="btn-group">
		                                <button class="btn green btn-xs btn-outline dropdown-toggle" data-toggle="dropdown">
		                                	${window.app.$t('Tools')}
		                                    <i class="fa fa-angle-down"></i>
		                                </button>
		                                <ul class="dropdown-menu pull-right">
		                                	${viewBtn}
		                                    ${editBtn}
		                                    ${deleteBtn}
		                                </ul>
		                            </div>`;
						jQuery(nTd).html(tools);
					}}
				],
				headers: [
					{'title' : 'Name', 'class': ''},
					{'title' : 'Email', 'class': ''},
					{'title' : 'City', 'class': ''},
					{'title' : 'Actions', 'class': ''}
				],
				processing: true,
        		serverSide: true,
        		index: {
        			present: true,
        			title: 'ID',
        			class: 'index'
        		},
        		columnDefs: [{
        			"searchable": false,
		            "orderable": false,
		            "targets": [0,4]
        		}],
        		lengthMenu: [25, 50, 75, 100 ]
			},
			portlet: {
				class: 'portlet light bordered',
				title: this.$t('All Schools'),
				icon: 'icon-graduation'
			},
			btns:{
				create: '<i class="icon-plus"></i>' + ' ' + this.$t('Create'),
				import: '<i class="icon-cloud-upload"></i>' + ' ' + this.$t('Import'),
			}
		}
	},
	components:{
		datatable: datatable,
		portlet: portlet
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
			// Dynamically created links
			if(jQuery(event.target).is('.router-link')){
				event.preventDefault();
				this.$router.push(event.target.getAttribute('href'));
			}
			// Delete Element event
			if(jQuery(event.target).is('.delete-element')){
				this.deleteElement(event, data, row);
			}
		},
		showCreateModal: function(){

		},
		showImportModal: function(){

		},
		deleteElement: function(event, data, row){
			let app = this;
			bootbox.confirm({
				title: app.$t('Move this school to trash?'),
				message: app.$t('Do you watn to move this school to trash?'),
				buttons:{
					confirm: {
						label: '<i class="icon-trash"></i> ' + app.$t('Move to trash'),
						className: 'btn-danger'
					}
				},
				callback: (result)=>{
					if(result){
						axios.delete('/api/v1/schools/' + data.id)
						.then( (response)=>{
							jQuery(row).fadeOut('slow');
							bootbox.alert({
								message: app.$t('Moved to trash!'),
								title: app.$t('Moved to trash!'),
								size: 'small'
							});
						} );
					}
				}
			});
		}
	},
}
</script>
