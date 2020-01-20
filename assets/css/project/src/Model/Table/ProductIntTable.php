<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProductIntTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('catalog_product_entity_int');
        $this->setPrimaryKey('value_id');
    }
}