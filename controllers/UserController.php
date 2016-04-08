<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'delete', 'index', 'view', 'update', 'Plot'],
                'rules' => [
                    [
                        'actions' => ['create', 'delete', 'index', 'view', 'update', 'Plot'],
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

    public function actionPlot() {

        $from = isset($_GET['fromuser']) ? strtotime($_GET['fromuser']) : strtotime('-25 day', time());
        $to = isset($_GET['touser']) ? strtotime($_GET['touser']) : time();
        $to = strtotime('+1 day', $to);

        //Find Points
        $start = $from;
        $end = strtotime('+1 day', $start);
        $points = [];
        while ($start < $to) {
            $total = Yii::$app->db->createCommand("SELECT COUNT(*) FROM user WHERE created_at>=FROM_UNIXTIME({$start}) AND created_at<=FROM_UNIXTIME({$end})")->queryScalar();
            array_push($points, [$start * 1000, $total]);
            $start = strtotime('+1 day', $start);
            $end = strtotime('+1 day', $start);
        }

        $response = [
            'status' => true,
            'points' => $points
        ];
        echo json_encode($response);
    }

    public function actionExport() {
        ini_set('memory_limit', '-1');
        
        $model = User::find()
                //->offset(2000)
                //->limit(3000)
                ->orderBy('created_at ASC')->all();

        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $ews = $objPHPExcel->getSheet(0);
        $ews->setTitle('Users');
        $filename = 'Users - ' . date('Y-m-d');

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Paypal Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Phone');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Country');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Has Image');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Gender');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Facebook User');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Date of Birth');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'BIO');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'User Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Number of Posts');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Posts Pageviews');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Profile Pageviews');
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Money Outstanding');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Total Money');
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Sign Up Date');
        $i = 2;
        foreach ($model as $data) {
            if (isset($data->userStats)) {
                $objPHPExcel->getActiveSheet()->SetCellValue("A$i", $data->id);
                $objPHPExcel->getActiveSheet()->SetCellValue("B$i", $data->name);
                $objPHPExcel->getActiveSheet()->SetCellValue("C$i", filter_var($data->email, FILTER_VALIDATE_EMAIL) ? $data->email : '-');
                $objPHPExcel->getActiveSheet()->SetCellValue("D$i", empty($data->paypal_email) ? '-' : $data->paypal_email);
                $objPHPExcel->getActiveSheet()->SetCellValue("E$i", empty($data->phone) ? '-' : $data->phone);
                $objPHPExcel->getActiveSheet()->SetCellValue("F$i", !isset($data->location) ? '-' : $data->location->name);
                $objPHPExcel->getActiveSheet()->SetCellValue("G$i", empty($data->image) ? 'No' : 'Yes');
                $objPHPExcel->getActiveSheet()->SetCellValue("H$i", $data->gender == 1 ? 'M' : 'F');
                $objPHPExcel->getActiveSheet()->SetCellValue("I$i", empty($data->scId) ? 'No' : 'Yes');
                $objPHPExcel->getActiveSheet()->SetCellValue("J$i", $data->dob);
                $objPHPExcel->getActiveSheet()->SetCellValue("K$i", empty($data->bio) ? '-' : $data->bio);
                $objPHPExcel->getActiveSheet()->SetCellValue("L$i", $data->plan == 1 ? 'GOLD' : 'Noraml');
                $objPHPExcel->getActiveSheet()->SetCellValue("M$i", $data->userStats->post_count);
                $objPHPExcel->getActiveSheet()->SetCellValue("N$i", $data->userStats->post_total_views);
                $objPHPExcel->getActiveSheet()->SetCellValue("O$i", $data->userStats->profile_views);
                $objPHPExcel->getActiveSheet()->SetCellValue("P$i", $data->userStats->available_amount);
                $objPHPExcel->getActiveSheet()->SetCellValue("Q$i", $data->userStats->total_amount);
                $objPHPExcel->getActiveSheet()->SetCellValue("R$i", date('Y-m-d', strtotime($data->created_at)));
                $i++;
            }
        }

        $objPHPExcel->getActiveSheet()->getStyle("A1:R1")->applyFromArray(array(
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


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(25);

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setPreCalculateFormulas(true);
        $objWriter->save('php://output');
        exit();
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (isset($_GET['ex'])) {
            $emailArr = [];
            $Model = $dataProvider->getModels();
            foreach ($Model as $data) {
                if (filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
                    array_push($emailArr, $data->email);
                }
            }
            echo implode(', ', $emailArr);
            Yii::$app->end();
        }

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new User();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
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
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $posts = Yii::$app->db->createCommand("SELECT id FROM post where userId = {$id}")->queryAll();
        $arr = [];
        $postsarray = '';
        foreach ($posts as $post) {
            array_push($arr, $post['id']);
        }
        $postsarray = implode(', ', $arr);
        if (!empty($postsarray)) {
            Yii::$app->db->createCommand("DELETE FROM post_body where postId IN ({$postsarray})")->query();
            Yii::$app->db->createCommand("DELETE FROM post_stats where postId IN ({$postsarray})")->query();
            Yii::$app->db->createCommand("DELETE FROM post_tag where postId IN ({$postsarray})")->query();
            Yii::$app->db->createCommand("DELETE FROM post where userId = {$id}")->query();
        }

        Yii::$app->db->createCommand("DELETE FROM user_settings where userId = {$id}")->query();
        Yii::$app->db->createCommand("DELETE FROM user_stats where userId = {$id}")->query();
        Yii::$app->db->createCommand("DELETE FROM user_transactions where userId = {$id}")->query();
        Yii::$app->db->createCommand("DELETE FROM user where id = {$id}")->query();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
