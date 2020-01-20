<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class OrdersTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('sales_flat_order');   
        $this->setPrimaryKey('entity_id');
        $this->hasMany('QuoteItem',[
            'foreignKey'=>'quote_id',
            'bindingKey'=>'quote_id',
            'joinType'=>'inner'
        ]);
    }


}