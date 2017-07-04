<?php
/**
* @author Dhemy
* @contact m.dhemy@outlook.com
* 
* Implements HTTP status reponses with status codes
**/
namespace App\Beak;

use Yajra\Datatables\Datatables;
Class Response{

	private $headers;
	private $cookies;
	private $data;
	private $code;
	private $response;
	private $datatables;

	public function __construct(){
		$this->headers = [];
		$this->cookies = [];
		$this->response = collect([]);
		$this->code = 200;
		$this->datatables = false;
	}

	/**
	 * puts the status code within the response collection
	 * @return void
	 */
	
	private function putCode(){
		$this->response->put('status_code', $this->code);
	}

	/**
	 * puts data witin the response collection
	 * @return void
	 */
	
	private function putData(){
		$this->response->put('data', $this->data);
	}

	/**
	 * defines a cookie to be sent along with the rest of the HTTP headers
	 * @param  [string]  $name     The name of the cookie.
	 * @param  [string]  $value    The value of the cookie
	 * @param  integer $expire   The time the cookie expires. 
	 * @param  string  $path     The path on the server in which the cookie will be available on.
	 * @param  string  $domain   The (sub)domain that the cookie is available to.
	 * @param  boolean $secure   secure HTTPS connection or HTTP
	 * @param  boolean $httponly When TRUE the cookie will be made accessible only through the HTTP protocol.
	 * @return  this
	 */
	
	public function withCookie($name, 
			$value, 
			$expire = 0, 
			$path = '/', 
			$domain = "", 
			$secure = false, 
			$httponly = false){
		setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
		return $this;
	}

	/**
	 * Sets a cookie with the name token and the given value , it's HTTPOnly
	 * @param  [string]  $value    The value of the cookie
	 * @param  @param  integer $expire   The time the cookie expires. 
	 * @param  string  $path     The path on the server in which the cookie will be available on.
	 * @param  string  $domain   The (sub)domain that the cookie is available to.
	 * @param  boolean $secure   secure HTTPS connection or HTTP
	 * @return this
	 */
	
	public function withTokenCookie($value, $expire = 0, $path = "/", $domain = "", $secure=false){
		$this->withCookie('token', $value, $expire, $path, $domain, $secure, true);
		return $this;
	}

	/**
	 *  you may use the header method to add a series of headers 
	 *  to the response before sending it back to the user
	 * @param  [string] $name  [header name]
	 * @param  [string] $value [header value]
	 * @return this
	 */
	
	public function withHeader($name, $value){
		$this->headers[$name] = $value;
		return $this;
	}

	/**
	 * you may use the withHeaders method to specify an array of headers to be added to the response
	 * @param  [array] $headers 
	 * @return this
	 */
	
	public function withHeaders($headers){
		$this->headers = array_merge($this->headers, $headers);
		return $this;
	}

	/**
	 * Trigger method
	 * @param   $data response data
	 * @param  integer $code     status code
	 * @return illuminate json response
	 */
	
	public function respond(){

		if($this->datatables)
		{
			$response = $this->data;
		}else
		{
			$response = response()->json(
				$this->data, 
				$this->code, 
				$this->headers, 
				JSON_PRETTY_PRINT)->withHeaders($this->headers);
		}

		$this->datatables = false;
		return $response;
	}	

	/**
	 * handles the servers side Ajax request for datatables usign the yajra/laravel-datatables package
	 * @param  collection $data 
	 * @return response
	 */
	public function dataTables($data){
		$this->code = 200;
		$this->data = Datatables::of($data)->make(true);
		$this->datatables= true;
		return $this;
	}


	/**
	| -----------------------------------------------
	| Successful HTTP requests
	| -----------------------------------------------
	| 
	| Standard response for successful HTTP requests
	**/
	public function ok($data){
		$this->data = $data;
		$this->code = 200;
		return $this;
	}

	/**
	|-------------------------------------------------
	| Creation of a new resource
	|--------------------------------------------------
	|
	| The request has been fulfilled, resulting in the creation of a new resource
	**/

	public function created($data){
		$this->data = $data;
		$this->code = 201;
		return $this;
	}

	/**
	| ---------------------------------------------------
	| Client Errors
	| ---------------------------------------------------
	| The server cannot or will not process the request 
	| due to an apparent client error (Validation errors for example)
	**/
	
	public function badRequest($data){
		$this->data = $data;
		$this->code = 400;
		return $this;
	}

	/**
	| ---------------------------------------------------
	| Unauthorized user
	| ---------------------------------------------------
	| The user does not have the necessary credentials.
	| Can be used when the token is expired or not presented.
	**/

	public function unauthorized($data){
		$this->data = $data;
		$this->code = 401;
		return $this;
	}

	/**
	| ---------------------------------------------------
	| Forbidden "Do not have enough permissions"
	| ---------------------------------------------------
	|
	| The user might be logged in but does not have the necessary permissions for the resource.
	**/

	public function forbidden($data){
		$this->data = $data;
		$this->code = 403;
		return $this;
	}

	/**
	 * ------------------------------------------------
	 * Page not found
	 * -----------------------------------------------
	 *
	 * Page not found error 404!
	 */
	public function notFound($data = '404 Not found!'){
		$this->data = $data;
		$this->code = 404;
		return $this;
	}

	public function serverError($data = 'Inernal Server Error')
	{
		$this->data = $data;
		$this->code = 500;
		return $this;
	}

}