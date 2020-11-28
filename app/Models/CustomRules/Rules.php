<?php namespace App\Models\CustomRules;

use App\Models\GradoModel;
use App\Models\ProfesorModel;

class Rules 
{
    public function valido_profesor_id(int $id) : bool
    {
        $model = new ProfesorModel();
        $profesor = $model->find($id);
        return $profesor == null ? false : true;
    }

    public function valido_grado_id(int $id) : bool
    {
        $model = new GradoModel();
        $grade = $model->find($id);
        return $grade == null ? false : true;
    }
}