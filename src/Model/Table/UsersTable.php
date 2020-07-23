<?php
namespace App\Model\Table;

use App\Service\Utility;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        $this->setTable('users');
        $this->addBehavior('Timestamp');
    }
    public function beforeSave(EventInterface $event, EntityInterface $entity, \ArrayObject $options)
    {
        if($entity->isNew()){
            $hasher = new DefaultPasswordHasher();
            $entity->set('password',$hasher->hash($entity->get('password')));
        }
    }
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('name', 'Please give your name')
            ->notEmptyString('password', 'Please is required')
            ->lengthBetween('password', [4,8],'Password should be between 4 to 8 characters')
            ->email('email', false,'Please give correct Email')
            ->add('email', 'isUnique', [
                'rule' => function ($data, $provider) {
                    if (!empty($provider['data']['id'])) {
                        return true;
                    } else {
                        if ($this->find()->where(['email' => $data])->count() > 0) return "email is used before";
                    }
                    return true;
                },
                'message' => "email is used before"
            ]);
        return $validator;
    }

    public function autheticate($data){
        if(empty($data['email']) || empty($data['password'])){
            return Utility::responseFormat('error','email and password is required');
        }
        $user_info = $this->find()->select(['email','password','name'])->where(['email' => $data['email']])->first();
        if(empty($user_info)){
            return Utility::responseFormat('error','User not found');
        }
        $hasher = new DefaultPasswordHasher();
        if($hasher->check($data['password'],$user_info['password'])){
            return Utility::responseFormat('success',$user_info);
        }
        return Utility::responseFormat('error','wrong credential');
    }

}
