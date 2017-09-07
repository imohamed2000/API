<template>
	<portlet :props="{title: 'Student Management', icon: 'icon-organization'}">
		<div slot="body" class="row">
			<div class="col-md-8">
				<portlet :props="{title: 'Parents', icon: 'icon-organization', class:'solid grey-cararra'}">
					<div slot="body">
						<div class="row margin-bottom-20 ">
							<div class="col-md-12">
								<label for="search-parent" v-text="$t('Parent')"></label>
								<input type="text"
										id="search-parent"
										ref="searchParent"
										class="form-control"
										:placeholder="$t('Enter parent\'s name or email address')">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 stories-cont margin-bottom-20 ">
								<div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption">
                                            <i class="icon-bar-chart font-dark hide"></i>
                                            <span class="caption-subject font-dark bold uppercase" v-text="$t('Father')"></span>
                                        </div>
                                        <div class="actions">
                                            <button class="btn red btn-outline btn-circle btn-sm">X</button>
                                        </div>
                                    </div>
									<div class="photo">
				                        <img src="/pages/media/users/teambg3.jpg" alt="" class="img-responsive"> </div>
				                    <div class="title">
				                        <a href="#">Mark Wahlberg</a>
				                    </div>
				                    <div class="desc">
				                        <span>Father</span>
				                    </div>
								</div>
							</div>
							<div class="col-md-6 stories-cont margin-bottom-20 ">
								<div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption">
                                            <i class="icon-bar-chart font-dark hide"></i>
                                            <span class="caption-subject font-dark bold uppercase" v-text="$t('Mother')"></span>
                                        </div>
                                        <div class="actions">
                                            <button class="btn red btn-outline btn-circle btn-sm">X</button>
                                        </div>
                                    </div>
									<div class="photo">
				                        <img src="/pages/media/users/teambg2.jpg" alt="" class="img-responsive"> </div>
				                    <div class="title">
				                        <a href="#">Mark Wahlberg</a>
				                    </div>
				                    <div class="desc">
				                        <span>Mother</span>
				                    </div>
								</div>
							</div>
						</div>
					</div>
				</portlet>
			</div>
			<div class="col-md-4">
				<portlet :props="{title: 'Enrollment', icon: 'icon-organization', class:'solid grey-cararra'}">
					<form slot="body">
						<div class="form-group">
							<label for="grade-id" v-text="$t('Grade')"></label>
							<select name="grade_id" id="grade-id" class="form-control">
								<option value="" selected disabled>{{$t('Select Grade')}}</option>
								<option value="1">Grade #No. ONE</option>
							</select>
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<label for="section-id" v-text="$t('Section')"></label>
							<select name="section_id" id="section-id" class="form-control">
								<option value="" selected disabled>{{$t('Select Section')}}</option>
								<option value="1">Section #No. ONE</option>
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
		</div>
	</portlet>
</template>
<script>

import { mapActions } from 'vuex';
//import axios from '../helpers/http';
//import Errors from '../helpers/errors';
//import ladda from 'ladda';
//import toastr from '../helpers/toastr.js';
import $style from '../helpers/style.js';
let style = new $style();
//

import portlet from './Portlet';


export default{
	components: {
		portlet
	},
	data(){
		return {
			
		};
	},
	computed: {

	},
	mounted(){
		style.pushStyle('/pages/css/about.min.css');
	},
	destroyed(){
		style.popStyle('/pages/css/about.min.css');
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		}),
	},
	beforeRouteEnter(to, from, next){
		next(vm=>{
			vm.fetchData();
		});
	}
}
</script>
