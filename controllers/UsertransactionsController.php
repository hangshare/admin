<?php

namespace app\controllers;

use Yii;
use app\models\UserTransactions;
use app\models\UserTransactionsSearch;
use app\components\AwsEmail;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UsertransactionsController implements the CRUD actions for UserTransactions model.
 */
class UsertransactionsController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'delete', 'index', 'view', 'update'],
                'rules' => [
                    [
                        'actions' => ['create', 'delete', 'index', 'view', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserTransactions models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UserTransactionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserTransactions model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        if (isset($_POST['_csrf'])) {
            $model->image = $_POST['s3loc'];
            $model->paypal_transaction_Id = $_POST['paypal_transaction_Id'];
            $model->status = 1;
            AwsEmail::queueUser('54', 6, [
                '__amount__' => $model->amount,
                '__image__' => $model->image,
            ]);
            AwsEmail::queueUser($model->userId, 6, [
                '__amount__' => $model->amount,
                '__image__' => $model->image,
            ]);
            $model->save();
            return $this->redirect(['view', 'id' => $id]);
        }
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserTransactions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserTransactions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserTransactions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = UserTransactions::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}