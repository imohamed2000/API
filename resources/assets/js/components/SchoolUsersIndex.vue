<template>
	<div>
		<create-user ref="createUser"></create-user>
		<portlet :props="portlet">
			<div slot="tools">
				<button @click.prevent="showCreateModal" class="btn green" v-html="`<i class='icon-plus'></i> ${$t('New User')}`"></button>
				<button class="btn blue" v-html="`<i class='icon-cloud-upload'></i> ${$t('Import users')}`"></button>
			</div>
			<datatable @deleteElement='deleteUser' slot="body" :props="table" ref="datatable"></datatable>
		</portlet>
	</div>
</template>
<script>
import { mapActions,mapState } from 'vuex';
import portlet from './Portlet';
import datatable from './datatable';
import createUser from './SchoolUsersCreate';
import axios from '../helpers/http';

export default{
	props: ['school'],
	components: {
		portlet: portlet,
		datatable: datatable,
		createUser: createUser
	},
	data(){
		return {
			portlet: {
				class: 'portlet light bordered',
				title: `${this.school.name} ${this.$t('users')}`,
				icon: 'icon-people'
			}
		}
	},
	computed:{
		...mapState({
			loading: state => state.misc.loading
		}),
		baseUrl: function(){
			return `/school/${this.school.slug}/users`;
		},
		table: function(){
			let ajaxUrl = `/api/v1/school/${this.school.id}/users?datatables`;
			let table = {
				class: 'table table-striped table-bordered table-hover dt-responsive',
				width: '100%',
				processing: true,
    			// serverSide: true,
        		lengthMenu: [25, 50, 75, 100 ],
				ajax:{ url: ajaxUrl},
				headers: [
					{'title': this.$t('Name'), 'class': ''},
					{'title': this.$t('Email'), 'class': ''},
					{'title': this.$t('Role'), 'class': ''},
					{'title': this.$t('Actions'), 'class': ''},
				],
				columns: [
					{"data": "name", 'fnCreatedCell': (nTd, sData, oData, iRow, iCol)=>{
						jQuery(nTd).html(`
							<a class='router-link' href='${this.baseUrl}/${oData.id}'>
								${oData.name}
							</a>
							`);
					}},
					{"data": "email"},
					{"data": "role"},
					{"data": null, 'fnCreatedCell': (nTd, sData, oData, iRow, iCol)=>{
						let viewBtn = `
							<li>
								<a href="${this.baseUrl}/${oData.id}" class="router-link">
									<i class="icon-eye"></i>
                                    ${window.app.$t('View')}
								</a>
							</li>
						`;

						let editBtn = `
								<li>
									<a href="${this.baseUrl}/${oData.id}/edit" class="router-link">
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
								</div>
						`;
						jQuery(nTd).html(tools);
					}}
				],
				columnDefs: [{
        			"searchable": false,
		            "orderable": false,
		            "targets": [0,4]
        		}],
        		index:{
        			present: true,
        			title: this.$t('ID'),
        			class: 'index'
        		},
			}
			return table;
		}
	},
	mounted(){
		this.isLoading(false);
		let title = `${this.school.name} (Users)`;
		setTitle(this.$root, title, title);
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		}),
		showCreateModal: function(){
			this.$refs.createUser.$refs.createModal.props.show = true;
		},
		deleteUser: function (event, data, row){
			let oThis = this;
			let ajaxUrl = `/school/${this.school.id}/users/${data.id}`;
			bootbox.confirm({
				title: oThis.$t('Move this user to trash!'),
				message: oThis.$t('Are you sure you want to move this user to trash?'),
				buttons: {
					confirm: {
						label: '<i class="icon-trash"></i> ' + app.$t('Move to trash'),
						className: 'btn-danger'
					}
				},
				callback: (result)=>{
					if(result){
						axios.delete(ajaxUrl)
							.then( (response)=>{
								jQuery(row).fadeOut('slow');
								toastr.warning(
									this.$t('This user was moved to trash, you can restore data at any time!'),
									this.$t('Trashed!')
									);
							});
					}
				}
			});
		}
	}
}
</script>
