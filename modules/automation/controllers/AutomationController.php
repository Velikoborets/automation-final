<?php

namespace app\modules\automation\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use app\modules\automation\models\Rule;
use app\modules\automation\models\Condition;

class AutomationController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataprovider([
            'query' => Rule::find(),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $transaction = Yii::$app->db->beginTransaction();

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();

            $rule = new Rule();
            $rule->name = $post['name'];
            $rule->user_id = Yii::$app->user->id;

            if ($rule->save()) {
                if (isset($post['conditions']) && is_array($post['conditions'])) {
                    foreach ($post['conditions'] as $conditionData) {
                        $condition = new Condition();
                        $condition->rule_id = $rule->id;
                        $condition->field = $conditionData['field'];
                        $condition->operator = $conditionData['operator'];
                        $condition->value = $conditionData['value'];

                        if (!$condition->validate()) {
                            $transaction->rollback();
                            Yii::$app->session->setFlash('error', 'Не удалось сохранить условие. Ошибки: '
                            . implode(', ', $condition->getFirstErrors()));

                            return $this->redirect(['create']);
                        } else {
                            $condition->save();
                        }
                    }
                }
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Правило успешно сохранено.');

                return $this->redirect(['index']);
            }
        }

        return $this->render('create');
    }

    public function actionView($id)
    {
        $rule = $this->findModel($id);

        if ($rule->user_id == Yii::$app->user->id) {
            $conditionData = Condition::find()->where(['rule_id' => $rule->id])->all();

            $data = [];
            foreach ($conditionData as $condition) {

                $fields = $condition->availableFields();
                $field = '';
                foreach ($fields as $key => $value) {
                    if ($key == $condition->attributes['field']) {
                        $field = $value;
                    }
                }

                $operators = $condition->availableOperators();
                $operator = '';
                foreach ($operators as $key => $value) {
                    if ($key == $condition->attributes['operator']) {
                        $operator = $value;
                    }
                }

                $data[] = [
                    'field' => $field,
                    'operator' => $operator,
                    'value' => $condition->value,
                    'ruleName' => $rule->name,
                ];
            }

            $dataProvider = new \yii\data\ArrayDataProvider([
                'allModels' => $data,
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
    
            return $this->render('show', [
                'dataProvider' => $dataProvider,
            ]);      
        }
    }

    public function actionDelete($id): yii\web\Response
    {
        $rule = $this->findModel($id);

        if ($rule->user_id == Yii::$app->user->id) {
            $rule->delete();
        }

        Yii::$app->session->setFlash('success', 'Правило удалено!');
        return $this->redirect(['index']);
    }

    public function findModel($id): Rule
    {
        $model = Rule::findOne($id);

        if ($model !== null) {
            return $model;
        }

        throw new \Exception('Данные пользователя не найдены!');
    }
}