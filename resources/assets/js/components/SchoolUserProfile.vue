<template>
	<div class="profile" v-if="user">
		<div class="row">
			<div class="col-md-4">
				<div class="portlet light bordered">
					<div class="portlet-title">
                        <div class="caption font-green-sharp">
                            <i class="icon-user font-green-sharp"></i>
                            <span class="caption-subject bold uppercase" v-text="user.name"></span>
                        </div>
                    </div>
                    <div class="portlet-body">
                    	<div class="sale-summary">
                    		<ul class="list-unstyled">
                    			<li>
									<img :src="user.avatar" 
									class="img-responsive pic-bordered pic-100 img-circle pic-center" alt="" />
								</li>
								<li>
									<span class="sale-info">
										<i class="fa fa-briefcase"></i> <span v-text="user.role"></span>
									</span>
								</li>
								<li>
									<span class="sale-info">
										<i class="fa fa-graduation-cap"></i> 1st, Grade
									</span>
								</li>
								<li>
									<span class="sale-info">
										<i class="fa fa-book"></i> Section A-2 
									</span>
								</li>
								<li>
									<span class="sale-info">
										<i class="fa fa-calendar"></i> 7/9/1990
									</span>
								</li>
                    		</ul>
                    	</div>
                    </div>
				</div>
			</div>
			<div class="col-md-4 stories-cont">
				<div class="portlet light bordered">
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
			<div class="col-md-4 stories-cont">
				<div class="portlet light bordered">
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
</template>
<script>
import { mapActions} from 'vuex';
import axios from '../helpers/http';

import $style from '../helpers/style.js';
let style = new $style();

export default{
	props: ['user'],
	data(){
		return {
			
		};
	},
	mounted(){
		this.isLoading(false);
		style.pushStyle('/pages/css/profile-2.min.css');
		style.pushStyle('/pages/css/about.min.css');
	},
	destroyed(){
		style.popStyle('/pages/css/profile-2.min.css');
		style.popStyle('/pages/css/about.min.css');
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		})
	}
}
</script>
<style>
	.pic-100{
		width: 100px;
		height: 100px;
	}
	.pic-center{
		display: block;
		margin: auto;
	}
</style>
