<?php

class Model_Quota extends ORM{
    protected $_table_name = 'quota';
    
    protected $_belongs_to = [
        'account' => [
            'foreign_key'=>'account_id',
            'model'=>'account'
        ]
    ];
}

