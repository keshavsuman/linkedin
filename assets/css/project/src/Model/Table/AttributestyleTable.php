<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AttributestyleTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('catelog_attribute_style');
        // $this->setPrimaryKey('attribute_id');
    }
}