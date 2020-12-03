<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class AuthFilter implements FilterInterface {
    use ResponseTrait;

    public function before(RequestInterface $request, $arguments = null){
        try {
            
            $key = Services::getSecretKey();
            $authHeader = $request->getServer('HTTP_AUTHORIZATION');
            if ($authHeader == null) {
                return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED, 'Token invalido');
            }else{
                $arr = explode('', $authHeader);
                $jwt = $arr[1];

                JWT::decode($jwt, $key, ['HS256']);
            }
        }catch (ExpiredException $ee) {
            return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED, 'Token caducado');
        } 
        catch (\Exception $e) {
            return Services::response()->getStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, 'Error en el servidor');
        }
    }

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){
        
    }

}