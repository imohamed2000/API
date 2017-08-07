import axios from 'axios';
const HTTP = axios.create();
HTTP.interceptors.response.use( (response)=>{
	return response;
}, (error) => {
	//TODO Handle errors of token, notFound, notAuthorized and etc ...
	if(error.response.status == 404)
		window.app.$router.replace('/404');
	return Promise.reject(error);
});
let apiUrl = document.querySelector('meta[name="api"]').getAttribute('api');
HTTP.defaults.baseURL = apiUrl;
export default HTTP;
