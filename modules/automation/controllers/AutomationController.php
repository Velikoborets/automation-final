<?php

namespace app\modules\automation\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use app\modules\automation\models\Rule;
use app\modules\automation\models\Condition;

class AutomationController extends \yii\web\Controller
{
    /**
     * Displays the list of rules
     *
     * @return string the index view containing the rules list
     */
    public function actionIndex(): string
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

    /**
     * Creates a rule and associated conditions
     *
     * @throws \yii\db\Exception if there are errors with the DB transaction
     * @return string|\yii\web\Response the view or a redirect to this page
     */
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
                            $transaction->rollBack();
                            Yii::$app->session->setFlash('error', 'Не удалось сохранить условие. Ошибка: '
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

            Yii::$app->session->setFlash('error', 'Не удалось сохранить правило. Ошибка: '
                . implode(', ', $rule->getFirstErrors()));
        }

        return $this->render('create');
    }

    /**
     * Displays the data of a specific rule
     *
     * @param integer $id the identifier of the model
     * @throws \Exception if there are errors associated with the DB transaction
     * @return string the view containing the data of the specific rule
     */
    public function actionView(int $id): string
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
                ];
            }

            $dataProvider = new \yii\data\ArrayDataProvider([
                'allModels' => $data,
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
        }

        return $this->render('show', [
            'dataProvider' => $dataProvider,
            'ruleName' => $rule->name,
        ]);
    }

    /**
     * Deletes the record with the rule
     *
     * @param integer $id the identifier of the model
     * @throws \Throwable if there are exceptions associated with searching for the record in the DB
     * @return \yii\web\Response redirects to the index view
     * */
    public function actionDelete(int $id): \yii\web\Response
    {
        $rule = $this->findModel($id);

        if ($rule->user_id == Yii::$app->user->id) {
            $rule->delete();
        }

        Yii::$app->session->setFlash('success', 'Правило удалено!');
        return $this->redirect(['index']);
    }

    /**
     * Find the record with the rule in the rules table
     *
     * @param integer $id the identifier of the model
     * @throws \Exception if the user is not found in the DB (rules table)
     * @return Rule the found model contains data from the DB
     */
    public function findModel($id): Rule
    {
        $model = Rule::findOne($id);

        if ($model !== null) {
            return $model;
        }

        throw new \Exception('Данные пользователя не найдены!');
    }
}