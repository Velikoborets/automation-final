<?php

use yii\helpers\Html;

$this->title = 'Создайте правило';

// Автоматически перенаправляет на действие нужного Controller;
$this->params['breadcrumbs'][] = ['label' =>'Список правил', 'url' => 'index'];

?>

<?= Html::beginForm(['rule/create'], 'post', ['id' => 'rule-form']) ?>
<?= Html::dropDownList('select') ?>
<?= Html::dropDownList('select') ?>
<?= Html::textInput('input') ?>
<?= Html::endForm() ?>


