<template>
	<nav class="navbar" role="navigation">
        <ul class="nav navbar-nav margin-bottom-35">
            <li :class="isActive(link)" v-for="link in links">
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
	methods: {
		isActive: function(link){
			return ( (this.$route.path == this.getPath(link.path)) ? 'active' : '' );
		},
		getPath: function(path){
			return (
					this.$route.matched[0].path
											.replace(":slug", this.$route.params.slug)
					+ '/' + path
				).replace(/\/$/, "");
		}
	}
}
</script>
