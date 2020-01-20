<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CatelogTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('catalog_catelog_entity');
        // $this->belongsTo('Category');
		 $this->belongsTo('Pageorder',[   
            'foreignKey'=>'id',
            'bindingKey'=>'catelog_id',   
            'joinType'=>'inner'
        ]);
        // $this->hasMany('Subcategory',['class'=>'Subcategory','foreignKey'=>'category_id','bindingKey'=>'id','dependent'=>true]);
    }
}