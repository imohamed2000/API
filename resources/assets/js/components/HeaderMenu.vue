<template>
	<!-- BEGIN HEADER MENU -->
    <div class="nav-collapse collapse navbar-collapse navbar-responsive-collapse">
        <ul class="nav navbar-nav">
            <li :class="{
            	'dropdown dropdown-fw dropdown-fw-disabled': !inMatched('stats'),
            	'dropdown dropdown-fw dropdown-fw-disabled active open selected': inMatched('stats')
            	}">
                <a href="javascript:;" class="text-uppercase">
                    <i class="icon-home"></i> Dashboard </a>
                <ul class="dropdown-menu dropdown-menu-fw">
                    <li>
                        <router-link to="/">
                            <i class="icon-bar-chart"></i> Default </router-link>
                    </li>
                    <li>
                        <a href="dashboard_2.html">
                            <i class="icon-bulb"></i> Dashboard 2 </a>
                    </li>
                    <li>
                        <a href="dashboard_3.html">
                            <i class="icon-graph"></i> Dashboard 3 </a>
                    </li>
                </ul>
            </li>
            <li :class="{
            	'dropdown dropdown-fw dropdown-fw-disabled': !inMatched('schools'),
            	'dropdown dropdown-fw dropdown-fw-disabled active open selected': inMatched('schools')
            	}">
                <a href="javascript:;" class="text-uppercase">
                    <i class="icon-layers"></i> Schools </a>
                <ul class="dropdown-menu dropdown-menu-fw">
                    <li>
                        <router-link to="/schools">
                            <i class="icon-graduation"></i> All Schools 
                        </router-link>
                    </li>
                    <li class="dropdown more-dropdown-sub">
                        <a href="javascript:;">
                            <i class="icon-docs"></i> Apps </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="app_todo.html">
                                    <i class="icon-clock"></i> Todo 1 </a>
                            </li>
                            <li>
                                <a href="app_todo_2.html">
                                    <i class="icon-check"></i> Todo 2 </a>
                            </li>
                            <li>
                                <a href="app_inbox.html">
                                    <i class="icon-envelope"></i> Inbox </a>
                            </li>
                            <li>
                                <a href="app_calendar.html">
                                    <i class="icon-calendar"></i> Calendar </a>
                            </li>
                            <li>
                                <a href="app_ticket.html">
                                    <i class="icon-notebook"></i> Support </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown more-dropdown-sub">
                        <a href="javascript:;">
                            <i class="icon-user"></i> User </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="page_user_profile_1.html"> Profile 1 </a>
                            </li>
                            <li>
                                <a href="page_user_profile_1_account.html"> Profile 1 Account </a>
                            </li>
                            <li>
                                <a href="page_user_profile_1_help.html"> Profile 1 Help </a>
                            </li>
                            <li>
                                <a href="page_user_profile_2.html"> Profile 2 </a>
                            </li>
                            <li>
                                <a href="page_user_login_1.html"> Login Page 1 </a>
                            </li>
                            <li>
                                <a href="page_user_login_2.html"> Login Page 2 </a>
                            </li>
                            <li>
                                <a href="page_user_login_3.html"> Login Page 3 </a>
                            </li>
                            <li>
                                <a href="page_user_login_4.html"> Login Page 4 </a>
                            </li>
                            <li>
                                <a href="page_user_login_5.html"> Login Page 5 </a>
                            </li>
                            <li>
                                <a href="page_user_login_6.html"> Login Page 6 </a>
                            </li>
                            <li>
                                <a href="page_user_lock_1.html"> Lock Screen 1 </a>
                            </li>
                            <li>
                                <a href="page_user_lock_2.html"> Lock Screen 2 </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown more-dropdown-sub">
                        <a href="javascript:;">
                            <i class="icon-social-dribbble"></i> General </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="page_general_about.html"> About </a>
                            </li>
                            <li>
                                <a href="page_general_contact.html"> Contact </a>
                            </li>
                            <li>
                                <a href="page_general_portfolio_1.html"> Portfolio 1 </a>
                            </li>
                            <li>
                                <a href="page_general_portfolio_2.html"> Portfolio 2 </a>
                            </li>
                            <li>
                                <a href="page_general_portfolio_3.html"> Portfolio 3 </a>
                            </li>
                            <li>
                                <a href="page_general_portfolio_4.html"> Portfolio 4 </a>
                            </li>
                            <li>
                                <a href="page_general_search.html"> Search 1 </a>
                            </li>
                            <li>
                                <a href="page_general_search_2.html"> Search 2 </a>
                            </li>
                            <li>
                                <a href="page_general_search_3.html"> Search 3 </a>
                            </li>
                            <li>
                                <a href="page_general_search_4.html"> Search 4 </a>
                            </li>
                            <li>
                                <a href="page_general_search_5.html"> Search 5 </a>
                            </li>
                            <li>
                                <a href="page_general_pricing.html"> Pricing </a>
                            </li>
                            <li>
                                <a href="page_general_pricing_2.html">
                                    <i class="icon-tag"></i> Pricing 2 </a>
                            </li>
                            <li>
                                <a href="page_general_faq.html"> FAQ </a>
                            </li>
                            <li>
                                <a href="page_general_blog.html"> Blog </a>
                            </li>
                            <li>
                                <a href="page_general_blog_post.html"> Blog Post </a>
                            </li>
                            <li>
                                <a href="page_general_invoice.html"> Invoice </a>
                            </li>
                            <li>
                                <a href="page_general_invoice_2.html"> Invoice 2 </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown more-dropdown-sub active">
                        <a href="javascript:;">
                            <i class="icon-settings"></i> System </a>
                        <ul class="dropdown-menu">
                            <li class="active">
                                <a href="layout_blank_page.html"> Blank Page </a>
                            </li>
                            <li>
                                <a href="page_system_coming_soon.html"> Coming Soon </a>
                            </li>
                            <li>
                                <a href="page_system_404_1.html"> 404 Page 1 </a>
                            </li>
                            <li>
                                <a href="page_system_404_2.html"> 404 Page 2 </a>
                            </li>
                            <li>
                                <a href="page_system_404_3.html"> 404 Page 3 </a>
                            </li>
                            <li>
                                <a href="page_system_500_1.html"> 500 Page 1 </a>
                            </li>
                            <li>
                                <a href="page_system_500_2.html"> 500 Page 2 </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- END HEADER MENU -->
</template>
<script>
	export default{
		data(){
			return {
				matched: this.$route.matched.map(component=> component.name)
			}
		},
		methods:{
			inMatched: function(name){
				return this.matched.indexOf(name) > -1;
			}
		},
		mounted(){

		}
	}
</script>