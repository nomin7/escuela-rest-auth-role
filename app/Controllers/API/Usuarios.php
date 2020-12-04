<?php namespace App\Controllers\API;

use App\Models\UsuarioModel;
use CodeIgniter\RESTful\ResourceController;

class Usuarios extends ResourceController
{
    public function __construct()
    {
        $this->model = $this->setModel(new UsuarioModel());
        helper('access_rol');
    }

    public function index()
	{
        
        try {
            if(!validateAccess(array('admin'), $this->request->getServer('HTTP_AUTHORIZATION')))
                return $this->failServerError('El rol no tiene acceso a este recurso');
        
            $usuarios = $this->model->findAll();
            return $this->respond($usuarios);
        } catch (\Exception $e) {
            return $this->failServerError('Error en el servidor');
        }
    }
    
    public function create()
    {
        try {
            if(!validateAccess(array('admin'), $this->request->getServer('HTTP_AUTHORIZATION')))
                return $this->failServerError('El rol no tiene acceso a este recurso');
            $usuario = $this->request->getJSON();
            if($this->model->insert($usuario)) {
                $usuario->id = $this->model->insertID();
               return $this->respondCreated($usuario);
            }else{
                return $this->failValidationError($this->model->validation->listErrors());
            }
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }

    public function delete($id = null)
	{
		try {
            if(!validateAccess(array('admin'), $this->request->getServer('HTTP_AUTHORIZATION')))
                return $this->failServerError('El rol no tiene acceso a este recurso');
            if ($id == null)
                return $this->failValidationError('No se ha pasado un Id valido');
            
            $usuarioVerificado = $this->model->find($id);
            if ($usuarioVerificado == null)
                return $this->failValidationError('No se ha encontrado un cliente con el '.$id);

            if($this->model->delete($id)) {
                return $this->respondDeleted($usuarioVerificado);
            }else{
                return $this->failServerError('No se ha podido eliminar el registro');
            }

            

        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
	}

}
