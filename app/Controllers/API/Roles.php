<?php namespace App\Controllers\API;

use App\Models\RolModel;
use CodeIgniter\RESTful\ResourceController;

class Roles extends ResourceController
{
    public function __construct()
    {
        $this->model = $this->setModel(new RolModel());
    }
	public function index()
	{
        $roles = $this->model->findAll();
		return $this->respond($roles);
    }
    
    public function create()
    {
        try {
            $rol = $this->request->getJSON();
            if($this->model->insert($rol)) {
                $rol->id = $this->model->insertID();
               return $this->respondCreated($rol);
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
            if ($id == null)
                return $this->failValidationError('No se ha pasado un Id valido');
            
            $rolVerificado = $this->model->find($id);
            if ($rolVerificado == null)
                return $this->failValidationError('No se ha encontrado un cliente con el '.$id);

            if($this->model->delete($id)) {
                return $this->respondDeleted($rolVerificado);
            }else{
                return $this->failServerError('No se ha podido eliminar el registro');
            }

            

        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
	}

}
