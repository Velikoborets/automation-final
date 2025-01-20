<?php

use yii\Helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\data\ActiveDataProvider;
use app\modules\automation\models\Rule;

/* @var $model app\modules\automation\models\Rule */

$this->title = 'Список правил';
$this->params['breadcrumbs'][] = ['label' => 'Автоматизация', 'url' => '/user/user/index'];

?>

<h2>Управление правилами</h2>

<?= Html::a('Задать условие', ['create'], ['class' => 'btn btn-primary']) ?>

<?= GridView::widget([
    'dataProvider' => new ActiveDataProvider([
        'query' => Rule::find(),
        'pagination' => [
            'pageSize' => 5,
        ],
    ]),
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        [
            'header' => '<div style="text-align: center;">Действия</div>',
            'class' => ActionColumn::class,
            'template' => '{linkTG} &nbsp {result} &nbsp {update} &nbsp {view} &nbsp {delete} ',
            'buttons' => [
                'result' => function ($url, $model) {
                    return Html::a('Результат Анализа', ['result', 'id' => $model->id],
                    ['class' => 'btn btn-danger table-actions']);
                },
                'linkTG' => function ($url, $model) {
                    return Html::a('Отправить в tg', ['linkTG', 'id' => $model->id],
                    ['class' => 'btn btn-primary table-actions']);
                }
            ],
            'contentOptions' => ['class' => 'table-cell'],
        ]
    ],
]) ?>
