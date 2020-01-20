<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PincodeTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('pincode_list');
        // $this->setPrimaryKey('id');
        // $this->hasMany('Product');
    }
}