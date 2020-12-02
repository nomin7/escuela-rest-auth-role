<?php namespace App\Controllers\API;

use App\Models\EstudianteModel;
use CodeIgniter\RESTful\ResourceController;

class Estudiantes extends ResourceController
{
    public function __construct()
    {
        $this->model = $this->setModel(new EstudianteModel());
    }
	public function index()
	{
        $estudiantes = $this->model->findAll();
		return $this->respond($estudiantes);
    }
    
    public function create()
    {
        try {
            $estudiante = $this->request->getJSON();
            if($this->model->insert($estudiante)) {
                $estudiante->id = $this->model->insertID();
               return $this->respondCreated($estudiante);
            }else{
                return $this->failValidationError($this->model->validation->listErrors());
            }
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }

    public function edit($id = null)
	{
        try {
            if ($id == null)
                return $this->failValidationError('No se ha pasado un Id valido');
            
            $estudiante = $this->model->find($id);
            if ($estudiante == null)
                return $this->failValidationError('No se ha encontrado un cliente con el '.$id);

            return $this->respond($estudiante);

        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }
    
    public function update($id = null)
	{
        try {
            if ($id == null)
                return $this->failValidationError('No se ha pasado un Id valido');
            
            $estudianteVerificado = $this->model->find($id);
            if ($estudianteVerificado == null)
                return $this->failValidationError('No se ha encontrado un cliente con el '.$id);


            $estudiante = $this->request->getJSON();
            if($this->model->update($id, $estudiante)) {
                $estudiante->id = $id;
                return $this->respondUpdated($estudiante);
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
            
            $estudianteVerificado = $this->model->find($id);
            if ($estudianteVerificado == null)
                return $this->failValidationError('No se ha encontrado un cliente con el '.$id);

            if($this->model->delete($id)) {
                return $this->respondDeleted($estudianteVerificado);
            }else{
                return $this->failServerError('No se ha podido eliminar el registro');
            }

            

        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
	}

}
