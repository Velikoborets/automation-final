<?php

namespace app\modules\automation\models;

use yii\db\ActiveRecord;
use app\modules\user\models\User;

/**
 * Model class for table "rules".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property integer $updated_at
 * @property integer $created_at
 * @property-read \yii\db\ActiveQuery $user
 */
class Rule extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'rules';
    }

    public function rules(): array
    {
        return [
            [['user_id', 'name'], 'required'],
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique', 'message' => 'Правило с таким именем уже существует.'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Имя правила',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets the user associated with the rule
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser(): \yii\db\ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
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