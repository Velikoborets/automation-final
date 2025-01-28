<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var object $dataProvider object with data from the view */
/** @var string $ruleName string with the rule name from the view */

$this->params['breadcrumbs'][] = ['label' => 'Список правил', 'url' => ['index']];
$this->params['breadcrumbs'][] = Html::encode($ruleName);

?>

<h1>Заданные условия</h1>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'field',
            'label' => 'Сущность',
        ],
        [
            'attribute' => 'operator',
            'label' => 'Оператор',
        ],
        [
            'attribute' => 'value',
            'label' => 'Значение',
        ],
    ]
]) ?>