<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class OfferTable extends Table
{
    public function initialize(array $config)
    {
        $this->setTable('offer_list');
        // $this->belongsTo('Category');
        // $this->hasMany('Subcategory',['class'=>'Subcategory','foreignKey'=>'category_id','bindingKey'=>'id','dependent'=>true]);
    }
}