<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AddressTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('customer_address_entity');
		$this->hasOne('Users',[   
            'foreignKey'=>'customer_id',   
            'bindingKey'=>'customer_id',
            'joinType'=>'inner'
        ]);
        $this->setPrimaryKey('entity_id');
    }
    public function validationAddress(Validator $validator)
    {
        $validator->notEmpty('name');
        $validator->notEmpty('contact');
        $validator->notEmpty('city');
        $validator->notEmpty('zipcode');
        $validator->notEmpty('addresss');
        $validator->notEmpty('customer_id');
        return $validator;
    }
    public function validationAddressupdate(Validator $validator)
    {
        $validator->notEmpty('name');
        $validator->notEmpty('contact');
        $validator->notEmpty('city');
        $validator->notEmpty('zipcode');
        $validator->notEmpty('addresss');
        $validator->notEmpty('customer_id');
        $validator->notEmpty('entity_id');
        return $validator;
    }
   


}