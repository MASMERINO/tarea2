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
        return $this->respond($this->model->findAll());
    }
    
    public function create()
	{
        try {
            $estudiante = $this->request->getJSON();
            if($this->model->insert($estudiante)):
                $estudiante->id = $this->model->insertID();
                return $this->respondCreated($estudiante);
            else:
                return $this->failValidationError($this->model->validation->listErrors());
            endif;
        } catch (\Exception $e) {
            return $this->failServerError('ha ocurrido un error en el servidor');
        }   
    }
    
    public function edit($id = null)
	{
        try {
            if($id == null)
                return $this->failValidationError('No se ha pasado un id valido');

            $estudiante = $this->model->find($id);
            if($estudiante == null)
                return $this->failNotFound('No se a encontrado un estudiante con el id: '.$id);
            return $this->respond($estudiante);
        } catch (\Exception $e) {
            return $this->failServerError('ha ocurrido un error en el servidor');
        }
    }
    
    public function update($id = null)
	{
        try {
            if($id == null)
                return $this->failValidationError('No se ha pasado un id valido');

            $verificado = $this->model->find($id);
            if($verificado == null)
                return $this->failNotFound('No se a encontrado un estudiante con el id: '.$id);
            
            $estudiante = $this->request->getJSON();
            if($this->model->update($id,$estudiante)):
                $estudiante->id = $id;
                return $this->respondUpdated($estudiante);
            else:
                return $this->failValidationError($this->model->validation->listErrors());
            endif;
            
        } catch (\Exception $e) {
            return $this->failServerError('ha ocurrido un error en el servidor');
        }
    }
    
    public function delete($id = null)
	{
        try {
            if($id == null)
                return $this->failValidationError('No se ha pasado un id valido');

            $verificado = $this->model->find($id);
            if($verificado == null)
                return $this->failNotFound('No se a encontrado un estudiante con el id: '.$id);
            
            if($this->model->delete($id))
                return $this->respondDeleted($verificado);
            return $this->failValidationError('No se ha podido eliminar el registro');
        } catch (\Exception $e) {
            return $this->failServerError('ha ocurrido un error en el servidor');
        }
    }
}