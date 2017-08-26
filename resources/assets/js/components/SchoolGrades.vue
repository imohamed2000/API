<template>
	<div>
		<portlet :props="portlet">
			<div class="row" slot="body">
				<div class="col-md-8">
					<p v-text="$t('Loading ...')" v-if="!grades"></p>
					<GradesIndex :grades="grades" v-if="grades" :url="gradesIndexUrl"></GradesIndex>
				</div>
				<div class="col-md-4">

					<SchoolGradeCreate 
						v-if="!editGrade" 
						:url="gradesIndexUrl" 
						:grades="grades">
						</SchoolGradeCreate>

					<SchoolGradeEdit v-if="editGrade" 
						:url="gradesIndexUrl" 
						:gradeID="activeGradeID" 
						:gradeName="activeGradeName">
						</SchoolGradeEdit>		
				</div>
			</div>		
		</portlet>
		<portlet :props="{title: $t('Sections')}">
			<div class="row" slot="body">
				<div class="col-md-8">
					<portlet :props="{title: $t('Sections'), class: 'solid grey-cararra'}">
						<p slot="body">
							DataTable goes here
						</p>
					</portlet>
				</div>
				<div class="col-md-4">
					<portlet :props="{title: $t('Map or edit'), class:'solid grey-cararra', icon:'icon-plus'}">
						<form action="" slot="body">
							<div class="form-group">
								<input type="text" name id="name" class="form-control" placeholder="Grade Name">
								<p class="help-block"></p>
							</div>
							<div class="row" slot="footer">
								<div class="col-md-12">
									<button class="pull-right btn green mt-ladda-btn ladda-button"
									 data-style="zoom-in" 
									 type="submit">Submit</button>
								</div>
							</div>
						</form>
					</portlet>
				</div>
			</div>
		</portlet>
	</div>
</template>
<script>

import { mapActions } from 'vuex';
import axios from '../helpers/http';
//import Errors from '../helpers/errors';
//import ladda from 'ladda';
//import toastr from '../helpers/toastr.js';
import $style from '../helpers/style.js';
let style = new $style();

import Portlet from './Portlet';
import GradesIndex from './SchoolGradesIndex';
import SchoolGradeCreate from './SchoolGradeCreate';
import SchoolGradeEdit from './SchoolGradeEdit';

export default{
	components: {
		portlet: Portlet,
		GradesIndex,
		SchoolGradeCreate,
		SchoolGradeEdit,
	},
	data(){
		return {
			grades: false,
			activeGradeID: null,
			activeGradeName: null,
			editGrade: true			
		};
	},
	computed: {
		gradesIndexUrl: function(){
			return `/school/${this.$parent.school.id}/grades`;
		},
		pageTitle: function(){
			return `${this.$parent.school.name} ${this.$t('Grades')}`;
		},
		portlet: function(){
			return {
				title: this.$t('Grades'),
				icon: 'icon-graduation'
			};
		},
	},
	mounted(){
		this.isLoading(false);
		setTitle(this, this.pageTitle, this.pageTitle);
		style.pushStyle('plugins/jquery-nestable/jquery.nestable.css');
		this.fetchData();
	},
	destroyed(){
		style.popStyle('plugins/jquery-nestable/jquery.nestable.css');
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		}),
		fetchData: function(){
			axios.get(this.gradesIndexUrl)
				.then((response)=>{
					this.grades = response.data;
				});
		}
	},
	beforeRouteEnter(to, from, next){
		next(vm=>{
			// vm.fetchData();
		});
	}
}
</script>
