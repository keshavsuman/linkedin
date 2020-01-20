<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ModeTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('courier_mode_type');
        // $this->belongsTo('Category');
        // $this->hasMany('Subcategory',['class'=>'Subcategory','foreignKey'=>'category_id','bindingKey'=>'id','dependent'=>true]);
    }
}