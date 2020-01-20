<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AdsTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('adverstisments');
        // $this->setPrimaryKey('attribute_id');
    }
}