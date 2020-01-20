<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class StockTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('catelog_product_stock');
		 $this->hasOne('AttributeOptionValue',[
        	'foreignKey'=>'value_id',
        	'bindingKey'=>'value_id',
        	'joinType'=>'inner',
        ]);
      
    }


}