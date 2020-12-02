<?php namespace App\Models;

use CodeIgniter\Model;

class EstudianteModel extends Model
{
    protected $table            = 'estudiante';
    protected $primaryKey       = 'id';

    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre', 'apellido', 'dui', 'genero', 'carnet', 'grado_id'];

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $validationRules  = [
        'nombre'        => 'required|alpha_space|min_length[2]|max_length[75]',
        'apellido'      => 'required|alpha_space|min_length[2]|max_length[75]',
        'dui'           => 'required|min_length[9]|max_length[10]',
        'genero'        => 'required|alpha_space|min_length[1]|max_length[1]',
        'carnet'        => 'required|min_length[8]|max_length[9]|regex_match[/^[a-zA-Z]+[0-9]+[0-9]/]',
        'grado_id'      => 'required|max_length[1]'
    ];

    protected $skipValidation   = false;
}