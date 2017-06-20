<template>
	<!-- BEGIN USER PROFILE -->
    <div class="btn-group-img btn-group">
        <button type="button" class="btn btn-sm md-skip dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <span>Hi, {{user.first_name}}</span>
            <img :src="user.avatar" alt=""> </button>
        <ul class="dropdown-menu-v2" role="menu">
            <li>
                <a href="page_user_profile_1.html">
                    <i class="icon-user"></i> My Profile
                    <span class="badge badge-danger">1</span>
                </a>
            </li>
            <li>
                <a href="app_calendar.html">
                    <i class="icon-calendar"></i> My Calendar </a>
            </li>
            <li>
                <a href="app_inbox.html">
                    <i class="icon-envelope-open"></i> My Inbox
                    <span class="badge badge-danger"> 3 </span>
                </a>
            </li>
            <li>
                <a href="app_todo_2.html">
                    <i class="icon-rocket"></i> My Tasks
                    <span class="badge badge-success"> 7 </span>
                </a>
            </li>
            <li class="divider"> </li>
            <li>
                <a href="page_user_lock_1.html">
                    <i class="icon-lock"></i> Lock Screen </a>
            </li>
            <li>
                <a href="#" @click.prevent="logout">
                    <i class="icon-key"></i> Log Out </a>
            </li>
        </ul>
    </div>
    <!-- END USER PROFILE -->
</template>
<script>
import {mapState} from 'vuex';
export default{
	computed:{
		...mapState({
			user: state => state.login.user
		}),
	},
}
</script>
