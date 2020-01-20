<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AttributeOptionValueTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('eav_attribute_option_value');
        $this->setPrimaryKey('value_id');
        $this->hasOne('AttributeOption',[
        	'foreignKey'=>'option_id',
        	'bindingKey'=>'option_id',
        	'joinType'=>'left',
        ]);
		 $this->hasOne('Stock',[
        	'foreignKey'=>'value_id',
        	'bindingKey'=>'value_id',
        	'joinType'=>'inner',
        ]);
    }
}