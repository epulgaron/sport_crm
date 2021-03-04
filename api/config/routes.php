<?php

/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/

return [
    // customs
    'logout' => 'site/logout',
    'signup' => 'site/signup',
    'login' => 'site/login',

    //site
    'site/<action:\w+>/<id:\d+>' => 'site/<action>',
    'site/<action:\w+>/<id:\w+>' => 'site/<action>',
    'site/<action:\w+>' => 'site/<action>',

   //specifics actions
    'GET,HEAD,OPTIONS <modules:\w+>/<controller:\w+>/select_2_list' => '<modules>/<controller>/select_2_list',
    'DELETE,OPTIONS <modules:\w+>/<controller:\w+>/delete_by_id' => '<modules>/<controller>/delete_by_id', 
    //General actions
    'GET,HEAD,OPTIONS <modules:\w+>/<controller:\w+>' => '<modules>/<controller>',
    'GET,HEAD,OPTIONS <modules:\w+>/<controller:\w+>/<id>' => '<modules>/<controller>/view',
    'PUT,PATCH,OPTIONS <modules:\w+>/<controller:\w+>/<id>' => '<modules>/<controller>/update',
    'POST,OPTIONS <modules:\w+>/<controller:\w+>' => '<modules>/<controller>/create',
    'DELETE,OPTIONS <modules:\w+>/<controller:\w+>/<id>' => '<modules>/<controller>/delete',
    '<modules:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<modules>/<controller>/<action>',
    'PUT,PATCH,OPTIONS <modules:\w+>/<controller:\w+>/update_multiple' => '<modules>/<controller>/update_multiple'
    ];

