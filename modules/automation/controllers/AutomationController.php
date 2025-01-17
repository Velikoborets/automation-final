<?php

namespace app\modules\automation\controllers;

class AutomationController extends \yii\base\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        return $this->render('create');
    }
}