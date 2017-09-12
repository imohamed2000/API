<template>
	<div class="col-md-4" v-if="user.role.slug=='student' && school">
		<portlet :props="{title: 'Enrollment', icon: 'icon-organization', class:'solid grey-cararra'}">
			<form slot="body">
				<div class="form-group" :class="gradeErrors.has('grade')">
					<label for="grade-id" v-text="$t('Grade')"></label>
					<select name="grade" id="grade-id" class="form-control" @change="onGradeChange" v-model="grade">
						<option value="0" selected disabled>{{$t('Select Grade')}}</option>
						<option :value="grade.id" 
							v-for="grade in grades" 
							v-text="grade.name" 
							:sections="JSON.stringify(grade.sections)"></option>
					</select>
					<p class="help-block"></p>
				</div>
				<div class="form-group">
					<label for="section-id" v-text="$t('Section')"></label>
					<select name="section_id" id="section-id" class="form-control" v-model="section">
						<option value="0" selected disabled>{{$t('Select Section')}}</option>
						<option :value="section.id" v-for="section in sections" v-text="section.name"></option>
					</select>
				</div>
				<div slot="footer">
					<div class="row">
						<div class="col-md-12">
							<div class="text-right">
								<button type="submit" 
										data-style="zoom-in" 
										class="btn green mt-ladda-btn ladda-button"
										v-text="$t('Save')">
								</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</portlet>
	</div>
</template>
<script>

import { mapActions } from 'vuex';
import axios from '../helpers/http';
import Errors from '../helpers/errors';
import ladda from 'ladda';
import toastr from '../helpers/toastr.js';
//import $style from '../helpers/style.js';
//let style = new $style();
import portlet from './Portlet';

export default{
	props: ['school', "user"],
	components: {
		portlet,
	},
	data(){
		return {
			gradeErrors: new Errors(),
			sectionErrors: new Errors(),
			grades: [],
			sections: [],
			grade: 0,
			section: 0,
		};
	},
	computed: {
		SectionUrl: function(){
			return `school/${this.school.id}/user/${this.user.id}/section`;
		},
		GradeUrl: function(){
			return `school/${this.school.id}/user/${this.user.id}/grade`;
		},
		SchoolGradesUrl: function(){
			return `school/${this.school.id}/grades`;
		},
	},
	mounted(){
		this.fetchData();
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		}),
		fetchData: function(){
			axios.get(this.SchoolGradesUrl).then((response)=>{ // Get School grades
				this.grades = response.data;
			}).then(()=>{ // Get current grade
				// axios.get(this.GradeUrl).then( (response)=>{
				// 	console.log(response.data)
				// } );
				console.log(this.GradeUrl)
				this.grade = 1;
				// set sections.
			}).then(()=>{ // get current section
				this.section = 0;
			});
		},
		onGradeChange: function(e){
			console.log(e.target.options.selectedIndex)
			if(e.target.options.selectedIndex != -1){
				let sections = JSON.parse( e.target.options[e.target.selectedIndex].getAttribute('sections') );
				this.sections = sections;
			}			
		},
	},
	beforeRouteEnter(to, from, next){
		next(vm=>{
			// vm.fetchData();
		});
	}
}
</script>
