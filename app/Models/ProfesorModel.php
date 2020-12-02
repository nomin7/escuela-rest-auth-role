<?php namespace App\Models;

use CodeIgniter\Model;

class ProfesorModel extends Model
{
    protected $table            = 'profesor';
    protected $primaryKey       = 'id';

    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre', 'apellido', 'profesion', 'telefono', 'dui'];

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $validationRules  = [
        'nombre'    => 'required|alpha_space|min_length[3]|max_length[75]',
        'apellido'  => 'required|alpha_space|min_length[3]|max_length[75]',
        'profesion' => 'required|alpha_space|min_length[1]|max_length[3]',
        'telefono'  => 'required|min_length[8]|max_length[9]',
        'dui'       => 'required|min_length[9]|max_length[10]',
    ];

    protected $skipValidation   = false;
}