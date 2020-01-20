<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProductVarcharTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('catalog_product_entity_varchar');
        $this->setPrimaryKey('value_id');
    }
}