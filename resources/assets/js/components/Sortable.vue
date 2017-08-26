<template>
	<div class="dd" ref="nestable">
        <ol class="dd-list">
            <li class="dd-item dd3-item" data-id="13">
                <div class="dd-handle dd3-handle"> </div>
                <div class="dd3-content"> Item 13 </div>
            </li>
            <li class="dd-item dd3-item" data-id="14">
                <div class="dd-handle dd3-handle"> </div>
                <div class="dd3-content"> Item 14 </div>
            </li>
        </ol>
    </div>
</template>
<script>

import { mapActions } from 'vuex';
//import axios from '../helpers/http';
//import Errors from '../helpers/errors';
//import ladda from 'ladda';
//import toastr from '../helpers/toastr.js';
import $style from '../helpers/style.js';
let style = new $style();

export default{
	data(){
		return {
			
		};
	},
	computed: {

	},
	mounted(){
		style.pushStyle('plugins/jquery-nestable/jquery.nestable.css');

	},
	destroyed(){
		style.popStyle('plugins/jquery-nestable/jquery.nestable.css');
	},
	methods: {
		...mapActions({
			isLoading: 'isLoading'
		}),
	},
	beforeRouteEnter(to, from, next){
		next(vm=>{
			vm.fetchData();
		});
	}
}
</script>
