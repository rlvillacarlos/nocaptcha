<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Account extends ORM{
    protected $_table_name = 'accounts';
    
    protected $_has_many = [
      'access'=>[
          'foreign_key'=>'account_id',
          'model'=>'access'          
      ]  
    ];
    protected $_has_one = [
      'quota'=>[
          'foreign_key'=>'account_id',
          'model'=>'quota'          
      ]  
    ];
}