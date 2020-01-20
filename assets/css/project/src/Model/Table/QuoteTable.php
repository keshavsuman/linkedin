<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class QuoteTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('sales_flat_quote');
        $this->setPrimaryKey('entity_id');
        $this->hasMany('QuoteItem',[
            'foreignKey'=>'quote_id',
            'bindingKey'=>'entity_id',
            'joinType'=>'inner'
        ]);
    }


}