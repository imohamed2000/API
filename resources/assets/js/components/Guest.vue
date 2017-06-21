<template>
	<div class="user-login-5">
        <div class="row bs-reset">
            <div class="col-md-6 bs-reset mt-login-5-bsfix">
                <div class="login-bg" style="background-image:url(pages/img/login/bg1.jpg)">
                    <img class="login-logo" src="pages/img/login/logo.png" /> </div>
            </div>
            <div class="col-md-6 login-container bs-reset mt-login-5-bsfix">
                <div class="login-content">
                    <h1 v-text="$t('Odigita LMS')"></h1>
                    <p v-text="$t(`Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,`)"></p>

                    <!-- Components start  -->
                    <login />
                    <reset-password />
                    <!-- Components end  -->

                </div>
                <div class="login-footer">
                    <div class="row bs-reset">
                        <div class="col-xs-5 bs-reset">
                            <ul class="login-social">
                                <li>
                                    <a href="javascript:;">
                                        <i class="icon-social-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="icon-social-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="icon-social-dribbble"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xs-7 bs-reset">
                            <div class="login-copyright text-right">
                                <p>Copyright &copy; Keenthemes 2015</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Login from './Login';
    import ResetPassword from './ResetPassword';
    import jsBackstretch from '../scripts/backstretch';
    import jsLogin from '../scripts/login';
    import $Assets from '../helpers/assets.js';

    let Assets = new $Assets();

	export default{
		components:{
            login: Login,
            'reset-password': ResetPassword
        },
        mounted: function(){
           Assets.addScript("/pages/scripts/login-5.js");
        },
        destroyed(){
            Assets.removeScript("/pages/scripts/login-5.js");
        }
	}
</script>