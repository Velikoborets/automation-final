<?php

use yii\helpers\Html;
use app\modules\automation\models\Condition;

$this->title = 'Список правил';
$this->params['breadcrumbs'][] = ['label' => 'Список правил', 'url' => 'index'];

$fieldsData = json_encode(Condition::availableFields());
$operatorsData = json_encode(Condition::availableOperators());

?>

<h1>Задайте условия</h1>

<?php Yii::$app->session->getFlash('error') ?>

<?= Html::beginForm(['automation/create'], 'post', ['id' => 'rule-form']) ?>

<?= Html::textInput('name', '', ['placeholder' => 'Имя правила',
    'class' => 'form-control form-control-sm', 'required' => true]) ?>
<br>

<div id="conditions">
    <div class="condition-wrapper" data-default-rule="true">
        <?= Html::dropDownList('conditions[0][field]', null, Condition::availableFields(),
            ['prompt' => 'Сущность', 'class' => 'form-control form-control-sm']) ?>

        <?= Html::dropDownList('conditions[0][operator]', null, Condition::availableOperators(),
            ['prompt' => 'Знак', 'class' => 'form-control form-control-sm']) ?>

        <?= Html::textInput('conditions[0][value]', '',
            ['placeholder' => 'Значение', 'class' => 'form-control form-control-sm']) ?>

        <?= Html::button('+', ['class' => 'btn btn-success btn-sm', 'onclick' => 'createCondition()']) ?>
        <?= Html::button('-', ['class' => 'btn btn-danger btn-sm btn-m', 'onclick' => 'removeCondition(this);']) ?>
    </div>
</div>

<?= Html::hiddenInput('fields-data', $fieldsData, ['id' => 'fields-data']) ?>
<?= Html::hiddenInput('operators-data', $operatorsData, ['id' => 'operators-data']) ?>

<?= Html::submitButton('Создать правило', ['class' => 'btn btn-primary']) ?>
<?= Html::endForm() ?>