<?php namespace App\Controllers\API;

use App\Models\EstudianteModel;
use App\Models\GradoModel;
use App\Models\ProfesorModel;
use CodeIgniter\RESTful\ResourceController;

class Grados extends ResourceController
{
    public function __construct() 
    {
        $this->model = $this->setModel(new GradoModel());
    }

	public function index()
	{
        return $this->respond($this->model->findAll());
    }
    
    public function create()
	{
        try {
            $grado = $this->request->getJSON();
            if($this->model->insert($grado)):
                $grado->id = $this->model->insertID();
                return $this->respondCreated($grado);
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

            $grado = $this->model->find($id);
            if($grado == null)
                return $this->failNotFound('No se a encontrado un grado con el id: '.$id);
            return $this->respond($grado);
        } catch (\Exception $e) {
            return $this->failServerError('ha ocurrido un error en el servidor');
        }
    }
    public function data($id = null)
    {        
        try 
        {
            if($id == null):
                return $this->failValidationError('No se ha pasado un id valido');
            else:
                $estudiantes = new EstudianteModel();
                $profesores = new ProfesorModel();
                $grado = $this->model->find($id);
                $grado['profesor'] = $profesores->where('id',$grado['profesor_id'])->findAll();
                $grado['alumnos'] = $estudiantes->where('grado_id',$grado['id'])->findAll();
                return $this->respond($grado);
            endif;
        } catch (\Exception $e) {
            return $this->failServerError('ha ocurrido un error en el servidor');
        }
    }
    
    public function update($id = null)
	{
        try {
            if($id == null)
                return $this->failValidationError('No se ha pasado un id valido');

            $gradoVerificado = $this->model->find($id);
            if($gradoVerificado == null)
                return $this->failNotFound('No se a encontrado un grado con el id: '.$id);
            
            $grado = $this->request->getJSON();
            if($this->model->update($id,$grado)):
                $grado->id = $id;
                return $this->respondUpdated($grado);
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

            $gradoVerificado = $this->model->find($id);
            if($gradoVerificado == null)
                return $this->failNotFound('No se a encontrado un grado con el id: '.$id);
            
            if($this->model->delete($id))
                return $this->respondDeleted($gradoVerificado);
            return $this->failValidationError('No se ha podido eliminar el registro');
        } catch (\Exception $e) {
            return $this->failServerError('ha ocurrido un error en el servidor');
        }
    }
}