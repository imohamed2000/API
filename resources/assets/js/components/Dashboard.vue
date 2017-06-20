<template>
	<div>
		<!-- BEGIN CONTAINER -->
        <div class="wrapper">
            <app-header />

            <div class="container-fluid">
                <div class="page-content">
                   <breadcrumbs />
                   <router-view></router-view>
                </div>
                <app-footer />
            </div>

        </div>
        <!-- END CONTAINER -->
        
	</div>
</template>
<script>
	import Cookie from 'js-cookie';
	import axios from 'axios';
	import $Assets from '../helpers/assets.js';
	import {mapActions} from 'vuex';

    // Child components
    import Header from './Header';
    import Breadcrumbs from './Breadcrumbs';
    import Footer from './Footer';


	let Assets = new $Assets();

	export default{
        components:{
            'app-header': Header,
            'breadcrumbs': Breadcrumbs,
            'app-footer': Footer
        },
		methods:{
			...mapActions({
				setTitle: 'setTitle'
			}),
			logout: function(){
				axios.post('api/v1/logout')
						.then(response => {
							this.$store.dispatch('toGuest');
						})
						.catch( errors => {} );
			}
		},
		mounted(){
			document.getElementsByTagName("body")[0].setAttribute('class', "page-header-fixed page-sidebar-closed-hide-logo");
			Assets.addStyle('/layouts/layout5/css/layout.min.css');
			Assets.addStyle('/layouts/layout5/css/custom.min.css');
			Assets.addScript('/layouts/layout5/scripts/layout.min.js');
			Assets.addScript('/layouts/global/scripts/quick-sidebar.min.js');
			Assets.addScript('/layouts/global/scripts/quick-nav.min.js');
		},
		destroyed(){
			Assets.removeStyle('/layouts/layout5/css/layout.min.css');
			Assets.removeStyle('/layouts/layout5/css/custom.min.css');
			Assets.removeScript('/layouts/layout5/scripts/layout.min.js');
			Assets.removeScript('/layouts/global/scripts/quick-sidebar.min.js');
			Assets.removeScript('/layouts/global/scripts/quick-nav.min.js');
		}
	}
</script>