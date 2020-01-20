<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CategoryTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('catalog_category');
        $this->setPrimaryKey('id');
        $this->hasMany('Product');
    }
}