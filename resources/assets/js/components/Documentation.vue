<template>
	<div class="title m-b-md">
        {{ $t('This is a nice content') }}
        <router-view></router-view>
    </div>
</template>
<script>
	export default{
		mounted(){
			let lang = this.$i18n;
			setTimeout( ()=>{
				alert('Locale will be changed');
				lang.set('ar');
			} , 2000);
		}
	}
</script>