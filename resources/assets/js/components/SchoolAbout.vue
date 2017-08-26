<template>
	<div class="profile">
		<div class="row">
		    <div class="col-md-3">
		       <img :src="school.logo + `?id=${Math.random()}`" class="img-responsive pic-bordered" alt="" />
		    </div>
		    <div class="col-md-9">
		        <div class="row">
		            <div class="col-md-8 profile-info">
		                <h1 class="font-green sbold uppercase" v-text="school.name"></h1>
		                <p v-text="school.address"></p>
		                <p>
		                    <a :href="school.site" v-text="school.site"></a>
		                </p>
		                <ul class="list-inline">
		                    <li>
		                        <i class="fa fa-map-marker"></i> {{school.city}} </li>
		                    <li>
		                        <i class="fa fa-address-card"></i> {{school.email}} </li> 
		                    <li>
		                        <i class="fa fa-calendar"></i> {{createdAt(school.created_at)}} </li>
		                </ul>
		            </div>
		            <!--end col-md-8-->
		            <div class="col-md-4">
		                <div class="portlet sale-summary">
		                    <div class="portlet-title">
		                        <div class="caption font-red sbold"> School Summary </div>
		                    </div>
		                    <div class="portlet-body">
		                        <ul class="list-unstyled">
		                            <li>
		                                <span class="sale-info"> Total Users
		                                    <i class="fa fa-img-up"></i>
		                                </span>
		                                <span class="sale-num"> 23 </span>
		                            </li>
		                            <li>
		                                <span class="sale-info"> Total Students
		                                    <i class="fa fa-img-down"></i>
		                                </span>
		                                <span class="sale-num"> 87 </span>
		                            </li>
		                        </ul>
		                    </div>
		                </div>
		            </div>
		            <!--end col-md-4-->
		        </div>
		        <!--end row-->
		    </div>
		</div>
	</div>
</template>
<script>
import { mapActions,mapState } from 'vuex';
import $style from '../helpers/style.js';
import moment from 'moment';

let style = new $style();

export default{
	props: ['school'],
	computed:{
		...mapState({
			loading: state => state.misc.loading
		}),
	},
	mounted(){
		this.isLoading(true);
		style.pushStyle('/pages/css/profile-2.min.css');
		this.isLoading(false);
	},
	destroyed(){
		style.popStyle('/pages/css/profile-2.min.css');
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		}),
		createdAt: function(time){
			let createdAt = moment(time);
			return createdAt.format('MMMM Do YYYY');
		}
	},
	beforeRouteEnter(to, from, next){
		next(vm=>{
        	vm.$parent.fetchData();
		} );
	}
}
</script>
