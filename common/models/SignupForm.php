<?php

namespace common\models;

use common\modules\security\models\Users;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Users
{

    public function __construct($config = [])
    {
        $this->attributes = parent::attributes();
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return  parent::rules();
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        $user = new Users();
        $user->load($this->dirtyAttributes,'');
        $user->setPassword($this->user_password);
        $user->generateAuthKey();
        //$user->generateEmailVerificationToken();
        //$this->sendEmail($user);
        return $user->save()?$user:array('errors'=>$user->errors);
    }

    /**
     * Sends confirmation email to user
     * @param User_rbac $user user model to with email should be send
     * @return bool whether the email was sent
     */
    public function sendEmail($user)
    {
        $mailer = Yii::$app->mailer;
        $mailer->htmlLayout = '@common/mail/layouts/html';
        $mailer->textLayout = '@common/mail/layouts/text';
        return $mailer
            ->compose(
                ['html' => '@common/mail/emailVerify-html', 'text' => '@common/mail/emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($user->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}

