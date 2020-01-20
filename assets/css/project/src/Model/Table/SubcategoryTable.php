<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class SubcategoryTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('catalog_category_product');
        // $this->setPrimaryKey('product_id');
    }
}