<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AttributeOptionTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('eav_attribute_option');
        $this->setPrimaryKey('option_id');
        $this->hasOne('AttributeOptionValue',[
        	'foreignKey'=>'option_id',
        	'bindingKey'=>'option_id',
        	'joinType'=>'left',
        	'dependent'=>true,
        ]);
        $this->belongsTo('Attribute',[
        	'foreignKey'=>'attribute_id',
        	'bindingKey'=>'attribute_id',
        	'joinType'=>'left',
        ]);
    }
}