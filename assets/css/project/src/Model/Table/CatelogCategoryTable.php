<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CatelogCategoryTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('catalog_category_catelog');
        // $this->setPrimaryKey('product_id');
    }
}