import axios from 'axios';
const HTTP = axios.create();
HTTP.interceptors.response.use( (response)=>{
	
}, (error) => {
	
});
export default HTTP;
