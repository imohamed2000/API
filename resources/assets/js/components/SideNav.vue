<template>
	<nav class="navbar" role="navigation">
        <ul class="nav navbar-nav margin-bottom-35">
            <li :class="isActive(link)" v-for="link in links">
                <router-link :to="getPath(link.path)">
                    <i :class="link.icon"></i> {{ $t(link.text) }}
                </router-link>
            </li>
        </ul>

        <h3 v-text="$t('Quick Actions')" v-if="quick"></h3>
        <ul class="nav navbar-nav margin-bottom-35" v-if="quick">
        	<li :class="isActive(link)" v-for="link in quick">
                <router-link :to="getPath(link.path)">
                    <i :class="link.icon"></i> {{ $t(link.text) }}
                </router-link>
            </li>
        </ul>

    </nav>
</template>
<script>
export default{
	props: ['links'],
	data(){
		return{
			quick: false
		}
	},
	methods: {
		isActive: function(link){
			if( this.$route.path == this.getPath(link.path) ){
				if(link.quick !== undefined){
					this.quick = link.quick;
				}else{
					this.quick = false;
				}
			}
			return ( (this.$route.path == this.getPath(link.path)) ? 'active' : '' );
		},
		getPath: function(path){
			return (
					this.$route.matched[0].path
											.replace(":slug", this.$route.params.slug)
					+ '/' + path
				).replace(/\/$/, "");
		},
		getActiveLink(){
			console.log(this.links)
		}
	}
}
</script>
