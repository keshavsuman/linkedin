<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class SharelistTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('shared_list');
         $this->belongsTo('Catelog',[
            'foreignKey'=>'catelog_id',
            'bindingKey'=>'id',
            'joinType'=>'inner'
        ]);
    }


}