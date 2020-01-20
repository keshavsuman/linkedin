<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UserextraTable extends Table
{
    
    public function initialize(array $config)
    {
       $this->setTable('userextra');
    }

}  