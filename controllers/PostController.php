<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use app\models\PostSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\AwsEmail;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{

    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'delete', 'index', 'view', 'update', 'setfeatured', 'plot', 'export', 'inc'],
                'rules' => [
                    [
                        'actions' => ['create', 'delete', 'index', 'view', 'update', 'setfeatured', 'export', 'plot', 'inc'],
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

    public function actionInc()
    {
        if (isset($_POST['views']) && isset($_POST['price'])) {
            $id = $_POST['id'];
            $userId = $_POST['userId'];
            $total_price = $_POST['views'] * $_POST['price'];
            $total_views = $_POST['views'];
            Yii::$app->db->createCommand(
                "UPDATE `post_stats` SET `views`=`views`+{$total_views}, `profit` = `profit` + {$total_price} WHERE `postId`= {$id}")
                ->query();
            Yii::$app->db->createCommand(
                "UPDATE `user_stats` SET `post_total_views`=`post_total_views`+{$total_views}, `post_views`=`post_views`+{$total_views},
                `available_amount`=`available_amount`+{$total_price}, `total_amount`=`total_amount`+ {$total_price}
                WHERE `userId`= {$userId}")->query();

        }
        return $this->redirect(['index']);
    }

    public function actionPlot()
    {

        $from = isset($_GET['fromuser']) ? strtotime($_GET['fromuser']) : strtotime('-25 day', time());
        $to = isset($_GET['touser']) ? strtotime($_GET['touser']) : time();
        $to = strtotime('+1 day', $to);

        //Find Points
        $start = $from;
        $end = strtotime('+1 day', $start);
        $points = [];
        while ($start < $to) {
            $total = Yii::$app->db->createCommand("SELECT COUNT(*) FROM post WHERE created_at>=FROM_UNIXTIME({$start}) AND created_at<=FROM_UNIXTIME({$end})")->queryScalar();
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

    public function actionExport()
    {
        $model = Post::find()->all();

        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $ews = $objPHPExcel->getSheet(0);
        $ews->setTitle('Users');
        $filename = 'Posts - ' . date('Y-m-d');

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Title');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Pageviews');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Featured');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Has a cover image');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Created on');

        $i = 2;
        foreach ($model as $data) {
            $objPHPExcel->getActiveSheet()->SetCellValue("A$i", $data->id);
            $objPHPExcel->getActiveSheet()->SetCellValue("B$i", $data->title);
            $objPHPExcel->getActiveSheet()->SetCellValue("C$i", $data->stats->views);
            $objPHPExcel->getActiveSheet()->SetCellValue("D$i", $data->type == 1 ? 'Video' : 'Article');
            $objPHPExcel->getActiveSheet()->SetCellValue("E$i", $data->featured == 1 ? 'Yes' : 'No');
            $objPHPExcel->getActiveSheet()->SetCellValue("F$i", empty($data->cover) ? 'No' : 'Yes');
            $objPHPExcel->getActiveSheet()->SetCellValue("G$i", $data->created_at);
            $i++;
        }

        $objPHPExcel->getActiveSheet()->getStyle("A1:G1")->applyFromArray(array(
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
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(80);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setPreCalculateFormulas(true);
        $objWriter->save('php://output');
        exit();
    }


    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionApproval()
    {
        $searchModel = new PostSearch();
        $searchModel->published = 0;
        $searchModel->deleted = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('approval', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $searchModel->deleted = 0;
        $searchModel->published = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSetfeatured()
    {
        $this->layout = false;
        Yii::$app->db->createCommand("UPDATE post SET featured = {$_POST['value']} WHERE id = {$_POST['id']};")->query();
        echo 'done';
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAprovedpost($id)
    {
        $model = $this->findModel($id);
        $model->published = 1;
        $model->save(false);

        AwsEmail::queueUser($model->userId, 'post_aproved', [
            '__title__' => $model->title,
            '__url__' => "https://www.hangshare.com/{$model->urlTitle}/"
        ], 'ar');

        return $this->redirect(['approval']);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
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
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //Get User ID
        $deleted_post = Yii::$app->db->createCommand("
                SELECT 
                t.title,
                t.userId,
                stats.views,
                stats.profit
                FROM post t LEFT JOIN post_stats stats on (stats.postId = t.id) 
                where t.id={$id}")->queryOne();

        // DELETE POSTS
        Yii::$app->db->createCommand("UPDATE post SET deleted = 1 where id={$id}")->query();
        // DELETE POSTS
        //UPDATE USER STATS
        $diffPrice = $deleted_post['profit'];
        Yii::$app->db->createCommand("UPDATE user_stats SET
        post_views=post_views-{$deleted_post['views']},
        post_total_views=post_total_views-{$deleted_post['views']},
        post_count=post_count-1,
        total_amount=total_amount-{$diffPrice},
        available_amount=available_amount-{$diffPrice}
        WHERE userId={$deleted_post['userId']}")->query();

        AwsEmail::queueUser($deleted_post['userId'], 'post_deleted', [
            '__postTitle__' => $deleted_post['title'],
        ], 'ar');

        return $this->redirect(['approval']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
