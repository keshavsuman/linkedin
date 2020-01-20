<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class OrderItemTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('sales_flat_order_item');
        // $this->setPrimaryKey('item_id');
    }
    // public function validationItem(Validator $validator)
    // {
        // $validator->notEmpty('product_id');
        // $validator->notEmpty('customer_id');
        // $validator->notEmpty('quantity');
        // return $validator;
    // }
   


}