<?php
/**
 * Created by PhpStorm.
 * User: rus
 * Date: 21.04.19
 * Time: 14:47
 */

namespace app\controllers;


use app\models\LoginForm;
use app\models\SignupForm;
use app\models\User;
use Yii;
use yii\web\Controller;

class AuthController extends Controller
{
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->signup();
            return $this->redirect(['auth/login']);
        }

        return $this->render('signup', [
            'model' => $model
        ]);
    }

    public function actionTest()
    {
        $user = User::findOne(1);
//        Yii::$app->user->login($user);
        var_dump(Yii::$app->user->isGuest);
    }

}