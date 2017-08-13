<template>
	<div>
		<modal :props="modal">
			<h4 class="modal-title" slot="modal-title" v-text="modal.title"></slot></h4>
			<div slot="modal-content">
				<form ref="createForm" enctype="multipart/form-data" @submit.prevent="createFromSubmit" @keydown="createForm.errors.clear($event.target.name)">
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<!-- Fields sections start -->
								<div class="col-md-9">
									<div :class="{'form-group': !createForm.errors.has('name'), 'form-group has-error': createForm.errors.has('name')}">
										<label for="name" v-text="createForm.labels.name"></label>
										<input type="text" name="name" class="form-control" id="name" :placeholder="createForm.labels.name" v-model="createForm.data.name">
										<p class="help-block" v-show="createForm.errors.has('name')" v-text="createForm.errors.get('name')"></p>
									</div>

									<div :class="{'form-group': !createForm.errors.has('address'), 'form-group has-error': createForm.errors.has('address')}">
										<label for="address" v-text="createForm.labels.address"></label>
										<textarea v-model="createForm.data.address" name="address" id="address" class="form-control" :placeholder="createForm.labels.address"></textarea>
										<p class="help-block" v-show="createForm.errors.has('address')" v-text="createForm.errors.get('address')"></p>
									</div>
								</div>
								<!-- Logo section start -->
								<div class="col-md-3">
									<div :class="{'form-group': !createForm.errors.has('logo'), 'form-group has-error': createForm.errors.has('logo')}">
										<ImageUpload ref="imageUploadObj"
												 @clearErrors="clearUE"
												 :props="imageUpload">
										</ImageUpload>
										<p class="help-block" v-show="createForm.errors.has('logo')" v-text="createForm.errors.get('logo')"></p>
									</div>
								</div>
							</div>

							<div class="row">
								<!-- First Section -->
								<div class="col-md-6">
									<div :class="{'form-group': !createForm.errors.has('slug'), 'form-group has-error': createForm.errors.has('slug')}">
										<label for="slug" v-text="createForm.labels.slug"></label>
										<input v-model="createForm.data.slug" type="text" name="slug" id="slug" class="form-control" :placeholder="createForm.labels.slug">
										<p class="help-block" v-show="createForm.errors.has('slug')" v-text="createForm.errors.get('slug')"></p>
									</div>

									<div :class="{'form-group': !createForm.errors.has('city'), 'form-group has-error': createForm.errors.has('city')}">
										<label for="city" v-text="createForm.labels.city"></label>
										<input v-model="createForm.data.city" type="text" name="city" id="city" class="form-control" :placeholder="createForm.labels.city">
										<p class="help-block" v-show="createForm.errors.has('city')" v-text="createForm.errors.get('city')"></p>
									</div>

								</div>
								<!-- Second Section -->
								<div class="col-md-6">
									<div :class="{'form-group': !createForm.errors.has('email'), 'form-group has-error': createForm.errors.has('email')}">
										<label for="email" v-text="createForm.labels.email"></label>
										<input v-model="createForm.data.email" type="email" name="email" id="email" class="form-control" :placeholder="createForm.labels.email">
										<p class="help-block" v-show="createForm.errors.has('email')" v-text="createForm.errors.get('email')"></p>
									</div>

									<div :class="{'form-group': !createForm.errors.has('zip'), 'form-group has-error': createForm.errors.has('zip')}">
										<label for="zip" v-text="createForm.labels.zip"></label>
										<input v-model="createForm.data.zip" type="text" name="zip" id="zip" class="form-control" :placeholder="createForm.labels.zip">
										<p class="help-block" v-show="createForm.errors.has('zip')" v-text="createForm.errors.get('zip')"></p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" @click="modal.show = false" v-text="createForm.btns.close"></button>
						<button id="create-form-submit-btn" type="submit" class="btn green mt-ladda-btn ladda-button" data-style="zoom-in" :disabled="createForm.errors.any()" @click.prevent="createFromSubmit" v-text="createForm.btns.submit"></button>
					</div>
				</form>
			</div>
		</modal>
		<portlet :props="portlet">
			<div slot="tools">
				<button type="button" class="btn green" v-html="btns.create" @click.prevent="showCreateModal"></button>
				<button type="button" class="btn blue" @click.prevent="showImportModal" v-html="btns.import"></button>
			</div>
			<datatable slot="body" @rowClick="rowClick" :props="table" ref="datatable"></datatable>
		</portlet>
	</div>
</template>
<script>
import {mapActions} from 'vuex';
import jQuery from 'jquery';
import axios from '../helpers/http';
import Errors from '../helpers/errors';
import ladda from 'ladda';
import toastr from '../helpers/toastr.js';

require('bootstrap');
require('../helpers/bootbox');

// Required Components
import datatable from './datatable';
import portlet from './portlet';
import modal from './Modal';
import ImageUpload from './ImageUpload';


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
			modal:{
				id: 'school-create-modal',
				show: false,
				title: this.$t('Add new school'),
				size: 'large'
			},
			btns:{
				create: '<i class="icon-plus"></i>' + ' ' + this.$t('Create'),
				import: '<i class="icon-cloud-upload"></i>' + ' ' + this.$t('Import'),
			},
			createForm: {
				errors: new Errors(),
				data:{
					name: null,
					slug: null,
					email: null,
					address: null,
					city: null,
					zip: null,
					logo: null,
				},
				labels:{
					name: this.$t('School Name'),
					slug: this.$t('Slug or sub-domain'),
					email: this.$t('Email'),
					address: this.$t('Address'),
					city: this.$t('City'),
					zip: this.$t('ZIP'),
					logo: this.$t('Logo'),
				},
				btns: {
					close: this.$t('Close'),
					submit: this.$t('Submit'),
					animation: null,
				}
			},
			imageUpload: {
				defaultImage: '/img/school.png',
				name: 'logo'
			}
		}
	},
	components:{
		datatable: datatable,
		portlet: portlet,
		modal: modal,
		ImageUpload: ImageUpload
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
		clearUE: function(){
			this.createForm.errors.clear('logo');
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
			this.modal.show = true;
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
						axios.delete('schools/' + data.id)
						.then( (response)=>{
							jQuery(row).fadeOut('slow');
							toastr.warning(
									this.$t('This schools was moved to trash, you can restore it at any time!'),
									this.$t('Trashed!')
									);
						} );
					}
				}
			});
		},
		createFromSubmit: function(event){
			// Start sumbmit button animation
			this.submitAnimation = ladda.create( document.querySelector('#create-form-submit-btn') );
			this.submitAnimation.start();

			// Sending Request
			axios.post('schools', new FormData( this.$refs.createForm))
					.then( (response)=>{
						// Refresh the table
						this.$refs.datatable.refresh();
						// Reset form
						this.createFormReset();
						// Success Alert
						toastr.info(
								this.$t('Success!'),
								this.$t('A new school was added!')
								);
						this.submitAnimation.stop();
					} )
						.catch( (err)=>{
							this.createForm.errors.record( err.response.data );
							this.submitAnimation.stop();
						} );
		},
		createFormReset: function(){
			this.createForm.data = {
				name: null,
				slug: null,
				email: null,
				address: null,
				city: null,
				zip: null,
				logo: null,
			};
			this.$refs.imageUploadObj.reset();
		}
	},
	beforeRouteEnter(to, from, next){
		next(vm=>{
			vm.fetchData();
		});
	}
}
</script>
