<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Beak\Response;

class JwtAuthMiddleware
{   
    /**
     * to handle jwt auth
     * @var [JWTAuth]
     */
    private $jwt;

    /**
     * to handle json responses
     * @var \Beak\Response
     */
    private $response;

    public function __construct(JWTAuth $jwt){
        $this->jwt = $jwt;
        $this->response  = new Response();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        try{
            if (! $user = $this->jwt->parseToken()->authenticate()) {
                return $response->badRequest(['access_token'  => 'user_not_found'])->respond();
            }

        } catch (TokenExpiredException $e){
            return $this->response->Unauthorized(['access_token'  => 'token_expired'])->respond();
        } catch (TokenInvalidException $e){
            return $this->response->badRequest(['access_token'  => 'token_invalid'])->respond();
        } catch (JWTException $e){
            return $this->response->badRequest(['access_token'  => 'token_absent'])->respond();
        }

        $request->request->add(['auth_user' => $user]);
        return $next($request);
    }
}
