<?php

namespace App\Filters;

use App\Models\RolModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class AuthFilter implements FilterInterface {
    use ResponseTrait;

    public function before(RequestInterface $request, $arguments = null){
        try {
            
            $key = Services::getSecretKey();
            $authHeader = $request->getServer('HTTP_AUTHORIZATION');
            if ($authHeader == null)
                return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED, 'Token invalido');

                $arr = explode(' ', $authHeader);
                $jwt = $arr[1];
                $jwt = JWT::decode($jwt, $key, ['HS256']);

                $rolModel = new RolModel();
                $rol = $rolModel->find($jwt->data->rol);

                if ($rol)
                return Services::response()->getStatusCode(ResponseInterface::HTTP_UNAUTHORIZED, 'El Rol del JWT es invalido');

                return true;
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