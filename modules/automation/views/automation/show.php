<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */

$this->params['breadcrumbs'][] = ['label' => 'Список правил', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Заданные условия';

?>

<h1>Заданные условия</h1>

<!-- Отображаем таблицу с условиями -->
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
        [
            'attribute' => 'ruleName',
            'label' => 'Имя правила',
        ],
    ],
]) ?>