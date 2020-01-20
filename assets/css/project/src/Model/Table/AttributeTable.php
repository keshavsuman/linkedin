<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AttributeTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('eav_attribute');
        $this->setPrimaryKey('attribute_id');
    }
}