<template>
	<div class="title m-b-md">
        {{ header }}
    </div>
</template>

<script>
	import { mapGetters, mapState, mapMutations, mapActions } from 'vuex';
    export default {
    	computed:{
    		...mapState({
    			header: state=>state.example.header
    		}),
    	},
    	methods:{},
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
