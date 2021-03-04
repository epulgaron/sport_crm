<?php

/* @var $this yii\web\View */
/* @var $user \common\modules\security\models\Users*/


$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
Hello <?= $user->user_email ?>,

    <p>Siga el link de abajo para realizar la activación:</p>

<?= $resetLink ?>

