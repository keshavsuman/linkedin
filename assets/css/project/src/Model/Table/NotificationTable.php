<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class NotificationTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('notification');
        // $this->setPrimaryKey('attribute_id');
    }
}