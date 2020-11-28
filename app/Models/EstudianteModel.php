<?php namespace App\Models;

use CodeIgniter\Model;

class EstudianteModel extends Model
{
    protected $table            = 'estudiante';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre', 'apellido','dui','genero','carnet','grado_id'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    
    protected $validationRules  = [
        'nombre'    => 'required|alpha_space|min_length[3]|max_length[75]', 
        'apellido'  => 'required|alpha_space|min_length[3]|max_length[75]', 
        'genero'    => 'required|alpha_space|max_length[1]', 
        'carnet'    => 'required|alpha_numeric_space|min_length[3]|max_length[9]', 
        'dui'       => 'permit_empty|alpha_numeric_space|min_length[3]|max_length[10]', 
        'grado_id'  => 'required|integer|valido_grado_id', 
    ];

    protected $validationMessages = [
        'grado_id' => [
            'valido_grado_id' => 'Estimado usuario, el grado no existe'
        ]
    ];

    protected $skipValidation = false;
}