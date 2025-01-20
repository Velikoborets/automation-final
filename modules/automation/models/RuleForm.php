<?php

namespace app\modules\rule\models;

use yii\base\Model;

class RuleForm extends Model
{
    public $name;
    public $conditions = [];

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['conditions'], 'safe'],
        ];
    }
}