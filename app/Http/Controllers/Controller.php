<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Validator;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $response;
    protected $errors;
    
    public function __construct(){
        $this->response = new \App\Beak\Response;
    }

    public function validate($request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = Validator::make($request, $rules, $messages, $customAttributes);
        if($validator->fails())
        {
            $this->errors = $validator->errors();
            return false;
        }
        
        return true;
    }
}
