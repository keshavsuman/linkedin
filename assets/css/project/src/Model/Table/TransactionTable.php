<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class TransactionTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('user_transaction');
        // $this->setPrimaryKey('attribute_id');
    }
}