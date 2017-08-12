<template>
	<div>
		<div ref="fileInput" :class="{'fileinput fileinput-exists': props.currentFile, 'fileinput fileinput-new' : !props.currentFile}" data-provides="fileinput">
			
			<!-- Default Image -->
            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                <img :src="props.defaultImage" alt="" />
            </div>
			
			<!-- File Exists -->
            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
            	<img :src="props.currentFile" alt="" />
            </div>

            <div>
                <span class="btn default btn-file">
                    <span class="fileinput-new"> Select image </span>
                    <span class="fileinput-exists"> Change </span>
                    <input ref="input" type="file" :name="props.name" @change="onChange"> </span>
                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
            </div>
        </div>

		<script2 src="/plugins/bootstrap-fileinput/bootstrap-fileinput.js" unload="jQuery"></script2>
	</div>
</template>
<script>
import $style from '../helpers/style.js';
let style = new $style();
import jQuery from 'jquery';

export default{
	props: ['props'],
	mounted(){
		style.pushStyle('plugins/bootstrap-fileinput/bootstrap-fileinput.css');
		this.listenToEvents();
	},
	destroyed(){
		style.popStyle('plugins/bootstrap-fileinput/bootstrap-fileinput.css');
	},
	methods: {
		listenToEvents: function(){
			let oThis = this;
			let fileInput = this.$refs.fileInput;
			// This event is fired after a file is selected.
			jQuery(fileInput).on('change.bs.fileinput', function(event) {
				oThis.$emit('change', event);
				oThis.$emit('clearErrors', event);
			});
			// This event is fired when the file input is cleared.
			jQuery(fileInput).on('clear.bs.fileinput', function(event) {
				oThis.$emit('clear', event);
				oThis.$emit('clearErrors', event);
			});
			// This event is fired when the file input is reset.
			jQuery(fileInput).on('reset.bs.fileinput', function(event) {
				oThis.$emit('reset', event);
				oThis.$emit('clearErrors', event);
			});
		},
		onChange: function(e){
			if(!e.target.value.length)
				this.$emit('clear')
		},
		reset: function(){
			jQuery(this.$refs.fileInput).fileinput('clear');
		}
	},
}
</script>
