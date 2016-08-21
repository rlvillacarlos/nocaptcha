<?php

class Model_Access extends ORM{
    protected $_table_name = 'accesses';
    
    protected $_belongs_to = [
        'account' => [
            'foreign_key'=>'account_id',
            'model'=>'account'
        ]
    ];
}

