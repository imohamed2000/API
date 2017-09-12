<template>
	<portlet :props="{title: 'Student Management', icon: 'icon-organization'}" v-if="school">
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
			<StudentEnrollEdit :school="school" :user="user"></StudentEnrollEdit>
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

import StudentEnrollEdit from './StudentEnrollEdit';
import portlet from './Portlet';


export default{
	props: ['school', 'user'],
	components: {
		portlet,
		StudentEnrollEdit
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
			// vm.fetchData();
		});
	}
}
</script>
