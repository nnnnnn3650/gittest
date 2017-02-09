<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ArticlesTable extends Table
{
    public function initialize(array $config)
    {
      $this->addBehavior('Timestamp');
      $this->belongsTo('Categories', [
        'foreignKey' => 'category_id',
      ]);
    }

    public function validationDefault(Validator $validator)
    {
      $validator
        ->notEmpty('title')
        ->requirePresence('title')
        ->notEmpty('body')
        ->requirePresence('body');

      return $validator;
    }
}
?>
