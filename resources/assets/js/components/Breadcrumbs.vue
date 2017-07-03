<template>
	 <!-- BEGIN BREADCRUMBS -->
    <div class="breadcrumbs">
        <h1 v-text="pageTitle"></h1>
        <ol class="breadcrumb">
            <li>
                <a href="#">Home</a>
            </li>
            <li>
                <a href="#">Pages</a>
            </li>
            <li class="active">System</li>
        </ol>
        <!-- Sidebar Toggle Button -->
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".page-sidebar">
            <span class="sr-only">Toggle navigation</span>
            <span class="toggle-icon">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </span>
        </button>
        <!-- Sidebar Toggle Button -->
    </div>
    <!-- END BREADCRUMBS -->
</template>
<script>
    import {mapState} from 'vuex';
	export default{
        computed:{
            ...mapState({
                pageTitle: state=> state.misc.pageTitle
            }),
        }
    }
</script>
