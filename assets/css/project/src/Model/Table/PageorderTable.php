<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PageorderTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('page_order');
		  $this->hasOne('Category',[
            'foreignKey'=>'id',
            'bindingKey'=>'category_id',
            'joinType'=>'inner'
        ]);
		  $this->hasOne('Catelog',[
            'foreignKey'=>'id',
            'bindingKey'=>'catelog_id',
            'joinType'=>'inner'
        ]);
		
        // $this->belongsTo('Category');
        // $this->hasMany('Subcategory',['class'=>'Subcategory','foreignKey'=>'category_id','bindingKey'=>'id','dependent'=>true]);
    }
}