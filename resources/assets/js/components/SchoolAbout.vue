<template>
	<div class="profile">
		<div class="row">
		    <div class="col-md-3">
		       <img :src="school.logo" class="img-responsive pic-bordered" alt="" />
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
		        <div class="tabbable-line tabbable-custom-profile">
		            <ul class="nav nav-tabs">
		                <li class="active">
		                    <a href="#tab_1_11" data-toggle="tab"> Latest Customers </a>
		                </li>
		                <li>
		                    <a href="#tab_1_22" data-toggle="tab"> Feeds </a>
		                </li>
		            </ul>
		            <div class="tab-content">
		                <div class="tab-pane active" id="tab_1_11">
		                    <div class="portlet-body">
		                        <table class="table table-striped table-bordered table-advance table-hover">
		                            <thead>
		                                <tr>
		                                    <th>
		                                        <i class="fa fa-briefcase"></i> Company </th>
		                                    <th class="hidden-xs">
		                                        <i class="fa fa-question"></i> Descrition </th>
		                                    <th>
		                                        <i class="fa fa-bookmark"></i> Amount </th>
		                                    <th> </th>
		                                </tr>
		                            </thead>
		                            <tbody>
		                                <tr>
		                                    <td>
		                                        <a href="javascript:;"> Pixel Ltd </a>
		                                    </td>
		                                    <td class="hidden-xs"> Server hardware purchase </td>
		                                    <td> 52560.10$
		                                        <span class="label label-success label-sm"> Paid </span>
		                                    </td>
		                                    <td>
		                                        <a class="btn btn-sm grey-salsa btn-outline" href="javascript:;"> View </a>
		                                    </td>
		                                </tr>
		                                <tr>
		                                    <td>
		                                        <a href="javascript:;"> Smart House </a>
		                                    </td>
		                                    <td class="hidden-xs"> Office furniture purchase </td>
		                                    <td> 5760.00$
		                                        <span class="label label-warning label-sm"> Pending </span>
		                                    </td>
		                                    <td>
		                                        <a class="btn btn-sm grey-salsa btn-outline" href="javascript:;"> View </a>
		                                    </td>
		                                </tr>
		                                <tr>
		                                    <td>
		                                        <a href="javascript:;"> FoodMaster Ltd </a>
		                                    </td>
		                                    <td class="hidden-xs"> Company Anual Dinner Catering </td>
		                                    <td> 12400.00$
		                                        <span class="label label-success label-sm"> Paid </span>
		                                    </td>
		                                    <td>
		                                        <a class="btn btn-sm grey-salsa btn-outline" href="javascript:;"> View </a>
		                                    </td>
		                                </tr>
		                                <tr>
		                                    <td>
		                                        <a href="javascript:;"> WaterPure Ltd </a>
		                                    </td>
		                                    <td class="hidden-xs"> Payment for Jan 2013 </td>
		                                    <td> 610.50$
		                                        <span class="label label-danger label-sm"> Overdue </span>
		                                    </td>
		                                    <td>
		                                        <a class="btn btn-sm grey-salsa btn-outline" href="javascript:;"> View </a>
		                                    </td>
		                                </tr>
		                                <tr>
		                                    <td>
		                                        <a href="javascript:;"> Pixel Ltd </a>
		                                    </td>
		                                    <td class="hidden-xs"> Server hardware purchase </td>
		                                    <td> 52560.10$
		                                        <span class="label label-success label-sm"> Paid </span>
		                                    </td>
		                                    <td>
		                                        <a class="btn btn-sm grey-salsa btn-outline" href="javascript:;"> View </a>
		                                    </td>
		                                </tr>
		                                <tr>
		                                    <td>
		                                        <a href="javascript:;"> Smart House </a>
		                                    </td>
		                                    <td class="hidden-xs"> Office furniture purchase </td>
		                                    <td> 5760.00$
		                                        <span class="label label-warning label-sm"> Pending </span>
		                                    </td>
		                                    <td>
		                                        <a class="btn btn-sm grey-salsa btn-outline" href="javascript:;"> View </a>
		                                    </td>
		                                </tr>
		                                <tr>
		                                    <td>
		                                        <a href="javascript:;"> FoodMaster Ltd </a>
		                                    </td>
		                                    <td class="hidden-xs"> Company Anual Dinner Catering </td>
		                                    <td> 12400.00$
		                                        <span class="label label-success label-sm"> Paid </span>
		                                    </td>
		                                    <td>
		                                        <a class="btn btn-sm grey-salsa btn-outline" href="javascript:;"> View </a>
		                                    </td>
		                                </tr>
		                            </tbody>
		                        </table>
		                    </div>
		                </div>
		                <!--tab-pane-->
		                <div class="tab-pane" id="tab_1_22">
		                    <div class="tab-pane active" id="tab_1_1_1">
		                        <div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
		                            <ul class="feeds">
		                                <li>
		                                    <div class="col1">
		                                        <div class="cont">
		                                            <div class="cont-col1">
		                                                <div class="label label-success">
		                                                    <i class="fa fa-bell-o"></i>
		                                                </div>
		                                            </div>
		                                            <div class="cont-col2">
		                                                <div class="desc"> You have 4 pending tasks.
		                                                    <span class="label label-danger label-sm"> Take action
		                                                        <i class="fa fa-share"></i>
		                                                    </span>
		                                                </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="col2">
		                                        <div class="date"> Just now </div>
		                                    </div>
		                                </li>
		                                <li>
		                                    <a href="javascript:;">
		                                        <div class="col1">
		                                            <div class="cont">
		                                                <div class="cont-col1">
		                                                    <div class="label label-success">
		                                                        <i class="fa fa-bell-o"></i>
		                                                    </div>
		                                                </div>
		                                                <div class="cont-col2">
		                                                    <div class="desc"> New version v1.4 just lunched! </div>
		                                                </div>
		                                            </div>
		                                        </div>
		                                        <div class="col2">
		                                            <div class="date"> 20 mins </div>
		                                        </div>
		                                    </a>
		                                </li>
		                                <li>
		                                    <div class="col1">
		                                        <div class="cont">
		                                            <div class="cont-col1">
		                                                <div class="label label-danger">
		                                                    <i class="fa fa-bolt"></i>
		                                                </div>
		                                            </div>
		                                            <div class="cont-col2">
		                                                <div class="desc"> Database server #12 overloaded. Please fix the issue. </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="col2">
		                                        <div class="date"> 24 mins </div>
		                                    </div>
		                                </li>
		                                <li>
		                                    <div class="col1">
		                                        <div class="cont">
		                                            <div class="cont-col1">
		                                                <div class="label label-info">
		                                                    <i class="fa fa-bullhorn"></i>
		                                                </div>
		                                            </div>
		                                            <div class="cont-col2">
		                                                <div class="desc"> New order received. Please take care of it. </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="col2">
		                                        <div class="date"> 30 mins </div>
		                                    </div>
		                                </li>
		                                <li>
		                                    <div class="col1">
		                                        <div class="cont">
		                                            <div class="cont-col1">
		                                                <div class="label label-success">
		                                                    <i class="fa fa-bullhorn"></i>
		                                                </div>
		                                            </div>
		                                            <div class="cont-col2">
		                                                <div class="desc"> New order received. Please take care of it. </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="col2">
		                                        <div class="date"> 40 mins </div>
		                                    </div>
		                                </li>
		                                <li>
		                                    <div class="col1">
		                                        <div class="cont">
		                                            <div class="cont-col1">
		                                                <div class="label label-warning">
		                                                    <i class="fa fa-plus"></i>
		                                                </div>
		                                            </div>
		                                            <div class="cont-col2">
		                                                <div class="desc"> New user registered. </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="col2">
		                                        <div class="date"> 1.5 hours </div>
		                                    </div>
		                                </li>
		                                <li>
		                                    <div class="col1">
		                                        <div class="cont">
		                                            <div class="cont-col1">
		                                                <div class="label label-success">
		                                                    <i class="fa fa-bell-o"></i>
		                                                </div>
		                                            </div>
		                                            <div class="cont-col2">
		                                                <div class="desc"> Web server hardware needs to be upgraded.
		                                                    <span class="label label-inverse label-sm"> Overdue </span>
		                                                </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="col2">
		                                        <div class="date"> 2 hours </div>
		                                    </div>
		                                </li>
		                                <li>
		                                    <div class="col1">
		                                        <div class="cont">
		                                            <div class="cont-col1">
		                                                <div class="label label-default">
		                                                    <i class="fa fa-bullhorn"></i>
		                                                </div>
		                                            </div>
		                                            <div class="cont-col2">
		                                                <div class="desc"> New order received. Please take care of it. </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="col2">
		                                        <div class="date"> 3 hours </div>
		                                    </div>
		                                </li>
		                                <li>
		                                    <div class="col1">
		                                        <div class="cont">
		                                            <div class="cont-col1">
		                                                <div class="label label-warning">
		                                                    <i class="fa fa-bullhorn"></i>
		                                                </div>
		                                            </div>
		                                            <div class="cont-col2">
		                                                <div class="desc"> New order received. Please take care of it. </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="col2">
		                                        <div class="date"> 5 hours </div>
		                                    </div>
		                                </li>
		                                <li>
		                                    <div class="col1">
		                                        <div class="cont">
		                                            <div class="cont-col1">
		                                                <div class="label label-info">
		                                                    <i class="fa fa-bullhorn"></i>
		                                                </div>
		                                            </div>
		                                            <div class="cont-col2">
		                                                <div class="desc"> New order received. Please take care of it. </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="col2">
		                                        <div class="date"> 18 hours </div>
		                                    </div>
		                                </li>
		                                <li>
		                                    <div class="col1">
		                                        <div class="cont">
		                                            <div class="cont-col1">
		                                                <div class="label label-default">
		                                                    <i class="fa fa-bullhorn"></i>
		                                                </div>
		                                            </div>
		                                            <div class="cont-col2">
		                                                <div class="desc"> New order received. Please take care of it. </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="col2">
		                                        <div class="date"> 21 hours </div>
		                                    </div>
		                                </li>
		                                <li>
		                                    <div class="col1">
		                                        <div class="cont">
		                                            <div class="cont-col1">
		                                                <div class="label label-info">
		                                                    <i class="fa fa-bullhorn"></i>
		                                                </div>
		                                            </div>
		                                            <div class="cont-col2">
		                                                <div class="desc"> New order received. Please take care of it. </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="col2">
		                                        <div class="date"> 22 hours </div>
		                                    </div>
		                                </li>
		                                <li>
		                                    <div class="col1">
		                                        <div class="cont">
		                                            <div class="cont-col1">
		                                                <div class="label label-default">
		                                                    <i class="fa fa-bullhorn"></i>
		                                                </div>
		                                            </div>
		                                            <div class="cont-col2">
		                                                <div class="desc"> New order received. Please take care of it. </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="col2">
		                                        <div class="date"> 21 hours </div>
		                                    </div>
		                                </li>
		                                <li>
		                                    <div class="col1">
		                                        <div class="cont">
		                                            <div class="cont-col1">
		                                                <div class="label label-info">
		                                                    <i class="fa fa-bullhorn"></i>
		                                                </div>
		                                            </div>
		                                            <div class="cont-col2">
		                                                <div class="desc"> New order received. Please take care of it. </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="col2">
		                                        <div class="date"> 22 hours </div>
		                                    </div>
		                                </li>
		                                <li>
		                                    <div class="col1">
		                                        <div class="cont">
		                                            <div class="cont-col1">
		                                                <div class="label label-default">
		                                                    <i class="fa fa-bullhorn"></i>
		                                                </div>
		                                            </div>
		                                            <div class="cont-col2">
		                                                <div class="desc"> New order received. Please take care of it. </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="col2">
		                                        <div class="date"> 21 hours </div>
		                                    </div>
		                                </li>
		                                <li>
		                                    <div class="col1">
		                                        <div class="cont">
		                                            <div class="cont-col1">
		                                                <div class="label label-info">
		                                                    <i class="fa fa-bullhorn"></i>
		                                                </div>
		                                            </div>
		                                            <div class="cont-col2">
		                                                <div class="desc"> New order received. Please take care of it. </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="col2">
		                                        <div class="date"> 22 hours </div>
		                                    </div>
		                                </li>
		                                <li>
		                                    <div class="col1">
		                                        <div class="cont">
		                                            <div class="cont-col1">
		                                                <div class="label label-default">
		                                                    <i class="fa fa-bullhorn"></i>
		                                                </div>
		                                            </div>
		                                            <div class="cont-col2">
		                                                <div class="desc"> New order received. Please take care of it. </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="col2">
		                                        <div class="date"> 21 hours </div>
		                                    </div>
		                                </li>
		                                <li>
		                                    <div class="col1">
		                                        <div class="cont">
		                                            <div class="cont-col1">
		                                                <div class="label label-info">
		                                                    <i class="fa fa-bullhorn"></i>
		                                                </div>
		                                            </div>
		                                            <div class="cont-col2">
		                                                <div class="desc"> New order received. Please take care of it. </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="col2">
		                                        <div class="date"> 22 hours </div>
		                                    </div>
		                                </li>
		                            </ul>
		                        </div>
		                    </div>
		                </div>
		                <!--tab-pane-->
		            </div>
		        </div>
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
		this.$parent.fetchData();
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
	}
}
</script>
