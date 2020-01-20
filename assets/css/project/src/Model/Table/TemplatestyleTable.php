<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TemplatestyleTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('template_style');
        // $this->setPrimaryKey('attribute_id');
    }
}