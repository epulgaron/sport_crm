<?php


namespace common\components;


use yii\helpers\Json;

class JwtValidationData extends \sizeg\jwt\JwtValidationData
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->validationData->setIssuer('http://example.com');
        $this->validationData->setAudience('http://example.org');
        $this->validationData->setId('4f1g23a12aa');
        parent::init();
    }

    public static function get_token($id,$user){
        $jwt = \Yii::$app->jwt;
        $signer = $jwt->getSigner('HS256');
        $key = $jwt->getKey();
        $time = time();
        return (string)$jwt->getBuilder()
            ->issuedBy('http://example.com')// Configures the issuer (iss claim)
            ->permittedFor('http://example.org')// Configures the audience (aud claim)
            ->identifiedBy('4f1g23a12aa', true)// Configures the id (jti claim), replicating as a header item
            ->issuedAt($time)// Configures the time that the token was issue (iat claim)
            ->expiresAt($time + 3600)// Configures the expiration time of the token (exp claim)
            ->withClaim('uid', $id)// Configures a new claim, called "uid"
            ->withClaim('user', Json::encode($user->get_data()))// Configures a new claim, called "uid"
            ->getToken($signer, $key); // Retrieves the generated token

    }
}
