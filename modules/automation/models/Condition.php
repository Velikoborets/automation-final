<?php

namespace app\modules\automation\models;

use yii\db\ActiveRecord;

/**
 * Model class for table "conditions".
 *
 * @property integer $rule_id
 * @property integer $operator
 * @property integer $field
 * @property number $value
 * @property integer $created_at
 * @property integer $updated_at
 */
class Condition extends \yii\db\ActiveRecord
{
    public const LESS_THAN = 0;
    public const MORE_THAN = 1;
    public const LESS_THAN_OR_EQUAL = 2;
    public const MORE_THAN_OR_EQUAL = 3;
    public const EQUAL = 4;

    public const ROI = 0;
    public const COST = 1;
    public const REVENUE = 2;
    public const APR = 3;

    public static function tableName(): string
    {
        return 'conditions';
    }

    public static function availableOperators(): array
    {
        return [
            self::LESS_THAN => '<',
            self::MORE_THAN => '>',
            self::LESS_THAN_OR_EQUAL => '<=',
            self::MORE_THAN_OR_EQUAL => '>=',
            self::EQUAL => '=',
        ];
    }

    public static function availableFields(): array
    {
        return [
            self::ROI => 'ROI',
            self::COST => 'Cost',
            self::REVENUE => 'Revenue',
            self::APR => 'APR',
        ];
    }

    public function rules(): array
    {
        return [
            [['rule_id', 'field', 'operator', 'value'], 'required'],
            [['rule_id', 'field', 'operator'], 'integer'],
            [['value'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }
}