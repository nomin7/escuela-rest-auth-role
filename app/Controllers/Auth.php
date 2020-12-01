<?php namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Config\Services;
use Firebase\JWT\JWT;

class Auth extends BaseController
{
    use ResponseTrait;

    /**
     * Class constructor.
     */
    public function __construct()
    {
    }
	public function login(){
        

        try {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $usuarioModel = new UsuarioModel();
            $where = ['username' => $username, 'password' => $password];
            $validateUsuario = $usuarioModel->where($where)->find();
            if($validateUsuario == null)
                return $this->failNotFound('Usuario o pass no validos');

            // return $this->respond('Usuario encontrado');
            $jwt = $this->generateJWT($validateUsuario);
            return $this->respond(['token' => $jwt], 200);

        } catch (\Exception $e) {
            return $this->failServerError('Error en el servidor');
        }
    }

    protected function generateJWT($usuario){
        $key = Services::getSecretKey();
        $time = time();


        $payload = [
            'aud' => base_url(),
            'iat' => $time,
            'exp' => $time + 60,
        ];

        $jwt = JWT::encode($payload, $key);
        return $jwt;
    }

	//--------------------------------------------------------------------

}
