<template>
	<div>
		<!-- BEGIN CONTAINER -->
        <div class="wrapper">
            <app-header />

            <div class="container-fluid">
                <div class="page-content">
                    <breadcrumbs />
                    <div class="loading" v-if="loading">
				      Loading...
				    </div>
                   	<keep-alive><router-view v-show="!loading"></router-view></keep-alive>
                </div>
                <app-footer />
            </div>

        </div>
        <!-- END CONTAINER -->
        
        <script2 src='/layouts/layout5/scripts/layout.min.js' unload="jQuery"></script2>
		<script2 src='/layouts/global/scripts/quick-sidebar.min.js' unload="jQuery"></script2>
		<script2 src='/layouts/global/scripts/quick-nav.min.js' unload="jQuery"></script2>
	</div>
</template>
<script>
	import Cookie from 'js-cookie';
	import axios from 'axios';
	import $style from '../helpers/style.js';
	import {mapActions, mapState} from 'vuex';

    // Child components
    import Header from './Header';
    import Breadcrumbs from './Breadcrumbs';
    import Footer from './Footer';

    let $ = jQuery = require('jquery');
	let style = new $style();

	export default{
		computed:{
			...mapState({
				loading: state=>state.misc.loading
			}),
		},
        components:{
            'app-header': Header,
            'breadcrumbs': Breadcrumbs,
            'app-footer': Footer
        },
		methods:{
			...mapActions({
				setTitle: 'setTitle',
				setPageTitle: 'setPageTitle',
				getUserData: 'getUserData',
				isLoading: 'isLoading'
			}),
			
		},
		mounted(){
			document.getElementsByTagName("body")[0].setAttribute('class', "page-header-fixed page-sidebar-closed-hide-logo");
			style.pushStyle('/layouts/layout5/css/layout.min.css');
			style.pushStyle('/layouts/layout5/css/custom.min.css');
			style.pushStyle('/plugins/bootstrap-toastr/toastr.min.css');
			this.getUserData();
		},
		destroyed(){
			style.popStyle('/layouts/layout5/css/layout.min.css');
			style.popStyle('/layouts/layout5/css/custom.min.css');
			style.popStyle('/plugins/bootstrap-toastr/toastr.min.css');
		}
	}
</script>
