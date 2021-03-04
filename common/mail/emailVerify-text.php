<?php

/* @var $this yii\web\View */
/* @var $user \common\modules\security\models\Users */


$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->user_last_name]);
?>
Hello <?= $user->user_email ?>,

    <p>Siga el link de abajo para realizar la activación:</p>

<?= $verifyLink ?>

