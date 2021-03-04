<?php

/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
(new Dotenv\Dotenv(__DIR__ . '/../'))->load();

   return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host='.getenv('server_sport_crm').';port='.getenv('port_sport_crm').';dbname='.getenv('db_sport_crm').'',
        'username' => getenv('user_sport_crm'),
        'password' => getenv('password_db_sport_crm'),
        'charset' => 'utf8',
        'tablePrefix' => '',
    ];


