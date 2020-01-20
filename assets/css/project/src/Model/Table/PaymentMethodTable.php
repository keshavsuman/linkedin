<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PaymentMethodTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('payment_method');
        $this->setPrimaryKey('id');
    }
   


}