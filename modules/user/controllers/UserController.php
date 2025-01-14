<?php

namespace app\modules\user\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use app\modules\user\models\User;

class UserController extends Controller
{
    /**
     * Displays the login form and handles the login logic.
     *
     * @return string|Response the rendered view for the login page or a redirect response.
     */
    public function actionLogin()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = User::findOne(['username' => $model->username]);

            if ($user !== null) {
                $success = Yii::$app->user->login($user);

                if ($success) {
                    Yii::$app->session->setFlash('success', 'Вы авторизованы!');
                }

                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Не верные данные!');
            }
        }

        return $this->render('login', ['model' => $model]);
    }

    /**
     * Displays the user page if authenticated; otherwise redirects to the login page.
     *
     * @return Response|string the rendered view for the index page or a redirect response.
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
        }

        return $this->render('index');
    }
}
