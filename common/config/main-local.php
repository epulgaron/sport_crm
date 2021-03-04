<?php
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
return [
    'components' => [
           'mailer' => [
               'class' => 'yii\swiftmailer\Mailer',
               'transport' => [
                   'class' => 'Swift_SmtpTransport',
                   'host' => getenv('email_host'),  // ej. smtp.mandrillapp.com o smtp.gmail.com
                   'username' => getenv('email_username'),
                   'password' => getenv('email_password'),
                   'port' => getenv('email_port'), // El puerto 25 es un puerto comun tambien
               ],
           ],
        'db' => require(__DIR__ . '/db.php'),
        
    ],
];

