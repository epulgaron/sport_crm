<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \common\modules\security\models\Users */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->user_last_name]);
?>
<div class="verify-email">
    <p>Hello <?= Html::encode($user->user_email) ?>,</p>

    <p>Siga el link de abajo para realizar la activación:</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>

