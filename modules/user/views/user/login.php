<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = 'Авторизуйтесь';

?>

<?php Yii::$app->session->getFlash('error') ?>

<div class="user-login">
    <h2><?= Html::encode($this->title) ?></h2>

    <?php $form = ActiveForm::begin(['action' => ['user/login'], 'method' => 'post']) ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('login', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>