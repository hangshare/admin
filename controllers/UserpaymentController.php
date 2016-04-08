<?php

namespace app\controllers;

use Yii;
use app\models\UserPayment;
use app\models\UserPaymentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserpaymentController implements the CRUD actions for UserPayment model.
 */
class UserpaymentController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'delete', 'index', 'view', 'update','export'],
                'rules' => [
                    [
                        'actions' => ['create', 'delete', 'index', 'view', 'update','export'],
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

    public function actionExport() {
        $model = UserPayment::find()->all();

        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $ews = $objPHPExcel->getSheet(0);
        $ews->setTitle('User Payment');
        $filename = 'User Payment - ' . date('Y-m-d');

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'User Id');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'User Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Payied Amount');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Gold Account Start Date/Time');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Gold Account End Date/Time');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Transaction ID');

        $i = 2;
        foreach ($model as $data) {
            $objPHPExcel->getActiveSheet()->SetCellValue("A$i", $data->userId);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$i", isset($data->users) ? $data->users->name : 'Deleted User');
            $objPHPExcel->getActiveSheet()->SetCellValue("C$i", $data->price);
            $objPHPExcel->getActiveSheet()->SetCellValue("D$i", date('Y-m-d h:i:s', $data->start_date));
            $objPHPExcel->getActiveSheet()->SetCellValue("E$i", date('Y-m-d h:i:s', $data->end_date));
            $objPHPExcel->getActiveSheet()->SetCellValue("F$i", $data->transactionId);
            $i++;
        }

        $objPHPExcel->getActiveSheet()->getStyle("A1:F1")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => 'AAAAAA')
                )
            ),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'f9f9f9')),
            'font' => array(
                'bold' => true,
                'size' => 13
            ), 'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setPreCalculateFormulas(true);
        $objWriter->save('php://output');
        exit();
    }

    /**
     * Lists all UserPayment models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UserPaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserPayment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserPayment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new UserPayment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UserPayment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UserPayment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserPayment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserPayment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = UserPayment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
