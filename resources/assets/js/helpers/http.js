import axios from 'axios';
const HTTP = axios.create();
HTTP.interceptors.response.use( (response)=>{
	return response;
}, (error) => {
	//TODO Handle errors of token, notFound, notAuthorized and etc ...
	return error;
});
export default HTTP;
