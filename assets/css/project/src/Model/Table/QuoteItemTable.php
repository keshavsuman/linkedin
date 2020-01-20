<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class QuoteItemTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('sales_flat_quote_item');
        $this->setPrimaryKey('item_id');
		$this->hasOne('Product',[   
            'foreignKey'=>'id',   
            'bindingKey'=>'product_id',
            'joinType'=>'inner'
        ]);
    }
    public function validationItem(Validator $validator)
    {
        $validator->notEmpty('product_id');
        $validator->notEmpty('customer_id');
        $validator->notEmpty('quantity');
		
        return $validator;
    }
   


}