<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    public function actionIndex() {

        $totalMoney = Yii::$app->db->createCommand('SELECT SUM(available_amount) FROM user_stats')->queryScalar();
        $totalMoneyGenerated = Yii::$app->db->createCommand('SELECT SUM(total_amount) FROM user_stats')->queryScalar();
        $totalUsers = Yii::$app->db->createCommand('SELECT COUNT(*) FROM user')->queryScalar();
        $totalPosts = Yii::$app->db->createCommand('SELECT COUNT(*) FROM post')->queryScalar();
        return $this->render('index', [
                    'totalMoney' => number_format($totalMoney, 2),
                    'totalMoneyGenerated' => number_format($totalMoneyGenerated, 2),
                    'totalUsers' => $totalUsers,
                    'totalPosts' => $totalPosts
        ]);
    }

    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->goHome();
    }

}